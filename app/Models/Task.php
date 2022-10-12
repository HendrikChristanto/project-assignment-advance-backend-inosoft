<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'tasks';

    protected $fillable = ['title', 'description', 'is_done'];

    public function scopeFilter($query, array $filters)
    {
        $queryFilter = $query;

        if (isset($filters['title'])) {
            $queryFilter = $queryFilter->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['is_done'])) {
            return $query->where('is_done', '=', $filters['is_done']);
        }

        return $queryFilter;
    }
}
