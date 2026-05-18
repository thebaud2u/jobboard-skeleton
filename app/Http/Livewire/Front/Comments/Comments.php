<?php

namespace App\Http\Livewire\Front\Comments;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Enums\CommentStates;

use App\Models\Breed;
use App\Models\Company;
use App\Models\Comment;
use App\Models\User;

class Comments extends Component
{
	// Entities
	public Breed $breed;
	public Company $company;
	public Comment $comment;
	public Comment $userComment;
	public User $user;

	// Properties
	public $create = false;
	public $update = false;
	public $inModal = false;
	public $case;
	public $source;
	public $target;
	public $breeds;
	public $comments;
	public $userCommentSet = false;

	// Misc
	public $commentComponentKey = 0;

	#[On('comment-validated')]
	public function commentValidated()
	{

	}

	#[On('comment-deleted')]
	public function commentDeleted()
	{

	}

	public function redirectToRegister()
	{
		session(['url.intended' => route('breed-search.'.$this->target->species->getTranslation('slug', 'en').'-breeds.show', ['breed' => $this->target->slug])]);

		return redirect()->to(route('login'));
	}

	public function mount()
	{

	}

	public function render()
	{
		switch($this->case) {
			case 'breed':
				$this->comments = $this->breed->commentsReceived;
				$this->company = new Company;
				$this->user = new User;

				if(Auth::guard('web')->check() && Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
					if(Auth::guard('web')->user()->company()->count() > 0) {
						$this->company = Auth::guard('web')->user()->company;

						if($this->company->breedsBreed($this->breed->slug)) {
							$this->userComment = $this->company->comments()
								->whereHas('breed', function($whereHas) {
									$whereHas->where('slug', $this->breed->slug);
								})
								->first();

							if($this->userComment) {
								$this->userCommentSet = true;
								$this->comments = $this->breed->comments()
									->where('id', '<>', $this->userComment->id)
									->get();
							}
						}
					}
				}
				break;
			case 'user-about-breed':
				$this->comment = new Comment;

				if(Auth::guard('web')->check() && Auth::guard('web')->user()->hasRole('adopter')) $this->source = Auth::guard('web')->user();
				break;
			default:
				$this->comment = new Comment;
				break;
		}

		$this->commentComponentKey++;

		return view('livewire.front.comments.comments');
	}
}
