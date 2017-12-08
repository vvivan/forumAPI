<?php
/**
 * Created by PhpStorm.
 * User: nikol
 * Date: 12/7/2017
 * Time: 2:01 PM
 */

namespace App\Traits;


trait Orderable
{
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldestFirst($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}