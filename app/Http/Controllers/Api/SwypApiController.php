<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\ArticleTarget;
use App\Models\ArticleTag;
use App\Models\ArticleSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class SwypApiController extends Controller
{

    /**
     * Options JSON communes pour toutes les réponses API
     */
    private const JSON_OPTIONS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES; // Options pour une meilleure lisibilité et gestion des caractères spéciaux


    /**
     * Récupère toutes les races avec leur espèce parente
     * Endpoint: GET /api/swyp/especes
     * 
     * @return JsonResponse
     */
    public function apiSpecies(): JsonResponse
    {
        try {
            $breeds = Breed::select('id', 'name as value', 'species_id as parent')
                ->orderBy('parent') 
                ->orderBy('value')
                ->get();

            return response()->json($breeds, 200, [], self::JSON_OPTIONS);

        } catch (\Exception $e) {
            return $this->handleApiError($e, 'races');
        }
    
    }
    /**
     * Récupère les tags de l'article
     * Endpoint: GET /api/swyp/thematiques
     * 
     * @return JsonResponse
     */
    public function apiThematics(): JsonResponse
    {
        try {
            $tags = ArticleTag::select('id', 'name as value')
                ->orderBy('value')
                ->get();

            return response()->json($tags, 200, [], self::JSON_OPTIONS);
         } catch (\Exception $e) {
             return $this->handleApiError($e, 'thématiques');
         }
        
    }


    /**
     * Cibles de l'article
     * Endpoint: GET /api/swyp/cibles
     * 
     * @return JsonResponse
     */
    public function apiTargets(): JsonResponse
    {
        try {
            $targets = ArticleTarget::select('id', 'name as value')
                ->orderBy('value')
                ->get();

            return response()->json($targets, 200, [], self::JSON_OPTIONS);
         } catch (\Exception $e) {
             return $this->handleApiError($e, 'cibles');
         }
    }



    /**
     * Rubriques de l'article
     * Endpoint: GET /api/swyp/rubriques
     * 
     * @return JsonResponse
     */
    public function apiSections(): JsonResponse
    {
        try {
            $sections = ArticleSection::select('id', 'name as value')
                ->orderBy('value')
                ->get();

            return response()->json($sections, 200, [], self::JSON_OPTIONS);
         } catch (\Exception $e) {
             return $this->handleApiError($e, 'rubriques');
         }
    }


    private function handleApiError(\Exception $e, string $resource): JsonResponse
    {
        Log::error("Erreur API {$resource}: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString() //String formaté pour les logs
        ]);

        $response = [
            'success' => false,
            'error' => "Une erreur est survenue lors de la récupération des {$resource}",
            'message' => $e->getMessage()
        ];

        return response()->json($response, 500, [], self::JSON_OPTIONS);
    }
}