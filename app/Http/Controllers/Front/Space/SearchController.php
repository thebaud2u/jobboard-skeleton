<?php

namespace App\Http\Controllers\Front\Space\Searches;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Http\Controllers\Controller;

use App\Models\Search;

class SearchController extends Controller
{
	public function index(): View
	{
		$searches = Search::where('user_id', Auth::guard('web')->user()->id)
			->orderByDesc('updated_at')
			->get();

		return view('front.space.searches.index', compact('searches'));
	}

	public function save(Request $request): RedirectResponse
	{
		// $validated = $request->validate([
		// 	'search_name' => 'required|max:255',
		// ]);

		if(! empty($request->search_uuid)) {
			$search = Search::where('user_id', Auth::guard('web')->user()->id)
				->where('uuid', $request->search_uuid)
				->first();
		} else {
			$search = Search::where('user_id', Auth::guard('web')->user()->id)
				->where('thematic_id', (empty($request->thematic_id) ? null : $request->thematic_id))
				->where('post_type_id', (empty($request->post_type_id) ? null : $request->post_type_id))
				->where('category_id', (empty($request->category_id) ? null : $request->category_id))
				->orderByDesc('updated_at')
				->first();
		}

		if(empty($search?->id)) {
			$search = Search::create([
				'name' => $request->search_name,
				'user_id' => Auth::guard('web')->user()->id,
				'thematic_id' => $request->thematic_id ?? null,
				'post_type_id' => $request->post_type_id ?? null,
				'category_id' => empty($request->category_id) ? null : $request->category_id,
				'filters' => (empty($request->filters)) ? collect([]) : collect(json_decode($request->filters, true)),
			]);
		} else {
			$search->update([
				'name' => $request->search_name,
				'thematic_id' => $request->thematic_id ?? null,
				'post_type_id' => $request->post_type_id ?? null,
				'category_id' => empty($request->category_id) ? null : $request->category_id,
				'filters' => (empty($request->filters)) ? collect([]) : collect(json_decode($request->filters, true)),
			]);
		}

		return $this->loadSearch($search)
			->with('success', __('Search saved successfully.').'<br>&gt; <a href="'.route('space.searches.my-searches').'" class="underline">'.__('My saved searches').'</a>');
	}

	public function delete(string $uuid): RedirectResponse
	{
		$search = Search::where('user_id', Auth::guard('web')->user()->id)
			->where('uuid', $uuid)
			->first();

		if(! empty($search->id)) {
			$search->delete();

			return back()->with('success', __('Search deleted successfully.'));
		}

		return back()->with('error', __('Invalid UUID.'));
	}

	public function loadSearch(Search $search): RedirectResponse
	{
		return redirect()->route('posts', [
			'thematic' => $search->thematic ?? 'null',
			'postType' => $search->postType ?? 'null',
			'search' => $search,
		]);
	}
}
