<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Traits\HasValuesCollection;

class Subscription extends Model
{
	use HasValuesCollection, SoftDeletes;

	protected $fillable = [
		'checkout_session_id',
		'user_id',
		'offer_id',
		'quantity',
		'remaining_quantity',
		'end_date',
		'reference',
		'values',
		'from',
		'synchronized_with_stripe',
		'comment'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'values' => AsCollection::class,
		'end_date' => 'date',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime'
	];

	// Relations
	public function mailLogs(): MorphMany
	{
		return $this->morphMany(MailLog::class, 'model');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	public function offer(): BelongsTo
	{
		return $this->belongsTo(Offer::class);
	}
}
