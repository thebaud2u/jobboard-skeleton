<?php

namespace App\Services;

class EmbedService
{
	/**
	 * Vérifie si l'URL est un lien embed pour YouTube, Spotify ou Facebook.
	 */
	public function isEmbedUrl($url)
	{
		return $this->isYoutubeEmbed($url) || $this->isSpotifyEmbed($url) || $this->isFacebookEmbed($url);
	}

	/**
	 * Transforme une URL embed en URL normale.
	 */
	public function convertEmbedToNormal($url)
	{
		if ($this->isYoutubeEmbed($url)) {
			return $this->convertYoutubeEmbedToNormal($url);
		} elseif ($this->isSpotifyEmbed($url)) {
			return $this->convertSpotifyEmbedToNormal($url);
		} elseif ($this->isFacebookEmbed($url)) {
			return $this->convertFacebookEmbedToNormal($url);
		}

		return null; // Si ce n'est pas un embed valide
	}

	/**
	 * Convertit une URL normale en URL embed.
	 */
	public function convertToEmbed($url)
	{
		if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
			return $this->convertYoutubeToEmbed($url);
		} elseif (str_contains($url, 'spotify.com')) {
			return $this->convertSpotifyToEmbed($url);
		} elseif (str_contains($url, 'facebook.com')) {
			return $this->convertFacebookToEmbed($url);
		}

		return null;
	}

	/** --------------------------- YOUTUBE --------------------------- **/

	public function isYoutubeEmbed($url)
	{
		return preg_match('/^https?:\/\/(www\.)?youtube\.com\/embed\/([\w-]+)$/', $url);
	}

	public function convertYoutubeEmbedToNormal($url)
	{
		preg_match('/^https?:\/\/(www\.)?youtube\.com\/embed\/([\w-]+)$/', $url, $matches);
		return isset($matches[2]) ? "https://www.youtube.com/watch?v={$matches[2]}" : null;
	}

	public function convertYoutubeToEmbed($url)
	{
		preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $url, $matches);
		return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
	}

	/** --------------------------- SPOTIFY --------------------------- **/

	public function isSpotifyEmbed($url)
	{
		return preg_match('/^https?:\/\/open\.spotify\.com\/embed\/(track|album|playlist|episode)\/([\w-]+)$/', $url);
	}

	public function convertSpotifyEmbedToNormal($url)
	{
		preg_match('/^https?:\/\/open\.spotify\.com\/embed\/(track|album|playlist|episode)\/([\w-]+)$/', $url, $matches);
		return isset($matches[1], $matches[2]) ? "https://open.spotify.com/{$matches[1]}/{$matches[2]}" : null;
	}

	public function convertSpotifyToEmbed($url)
	{
		preg_match('/https?:\/\/open\.spotify\.com\/(track|album|playlist|episode)\/([\w-]+)/', $url, $matches);
		return isset($matches[1], $matches[2]) ? "https://open.spotify.com/embed/{$matches[1]}/{$matches[2]}" : null;
	}

	/** --------------------------- FACEBOOK --------------------------- **/

	public function isFacebookEmbed($url)
	{
		return preg_match('/^https?:\/\/www\.facebook\.com\/plugins\/video\.php\?href=(.+)$/', $url);
	}

	public function convertFacebookEmbedToNormal($url)
	{
		preg_match('/^https?:\/\/www\.facebook\.com\/plugins\/video\.php\?href=(.+)$/', $url, $matches);
		return isset($matches[1]) ? urldecode($matches[1]) : null;
	}

	public function convertFacebookToEmbed($url)
	{
		if ($this->isFacebookEmbed($url)) {
			return $url;
		}
		if (preg_match('/^https:\/\/(www\.)?facebook\.com\/.*\/videos\/.*/i', $url, $matches) ||
		preg_match('/https?:\/\/www\.facebook\.com\/watch\/?\?v=(\d+)/', $url, $matches)) {
		
			$videoId = $matches[1]; // Extraire l'ID de la vidéo
			return 'https://www.facebook.com/plugins/video.php?href=' . urlencode($url);
		}
		if (preg_match('/https?:\/\/www\.facebook\.com\/(?:watch\/?\?v=|.*\/videos\/)(\d+)/', $url, $matches)) {
			return 'https://www.facebook.com/plugins/video.php?href=' . urlencode($url);
		}

		return null;
	}
}
