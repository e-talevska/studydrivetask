<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    const CACHE_KEY = 'favouriteImages';
    protected $fillable = ['datetime', 'user_id', 'image_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include popular images.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subWeek());
    }

}
