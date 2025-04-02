<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Concession extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
    ];

    protected $appends = [
        'created_at_human',
        'image_url',
    ];

    public function getCreatedAtHumanAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function scopeOrderByColumn($query, $column, $direction = 'asc')
    {
        return $query->orderBy($column, $direction);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['searchParam'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }
}
