<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'to_kitchen',
        'status',
    ];

    protected $appends = [
        'created_at_human',
        'concessions_total',
    ];

    /**
     * @return [type]
     */
    public function getCreatedAtHumanAttribute()
    {
        return Carbon::parse($this->created_at)->format('M d, Y h:i A');
    }

    /**
     * @return [type]
     */
    public function getConcessionsTotalAttribute()
    {
        return $this->concessions()->sum('price');
    }

    public function scopeOrderByColumn($query, $column, $direction = 'asc')
    {
        return $query->orderBy($column, $direction);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['searchParam'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('order_number', 'like', '%' . $search . '%');
            });
        });
    }
    /**
     * @return [type]
     */
    public function concessions()
    {
        return $this->belongsToMany(Concession::class, 'order_concessions')
            ->withTimestamps();
    }
}
