<?php

namespace App;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Orderable;

    protected $fillable = ['title'];

    /**
     * Defining relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defining relationship
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->oldestFirst();
    }
}
