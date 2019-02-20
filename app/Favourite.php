<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = ['datetime', 'user_id', 'image_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
