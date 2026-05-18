<?php

namespace App\Http\Livewire\Front\Space\Benefits;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Benefit;
class Benefits extends Component
{
	public $withNav = false;
	public $type = 'random';

	public function mount()
	{
	}

	public function render()
	{
		$benefitsAvailable = Benefit::whereHas('roles', function($whereHas) {
				$whereHas->whereIn('role_id', Auth::guard('web')->user()->roles->pluck('id')->toArray());
			})
			->whereDate('start_date', '<=', Carbon::now())
			->whereDate('end_date', '>=', Carbon::now());

		if($this->type == 'random') $benefitsAvailable = $benefitsAvailable->inRandomOrder();

		else {
			$benefitsAvailable = $benefitsAvailable->wherehas('benefitType', function($whereHas) {
					$whereHas->where('slug', $this->type);
				});
		}

		if(!$this->withNav) $benefitsAvailable = $benefitsAvailable->limit(2);

		$benefitsAvailable = $benefitsAvailable->get();

		return view('livewire.front.space.benefits.slot', compact('benefitsAvailable'));
	}
}
