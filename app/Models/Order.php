<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'to_kitchen',
        'queue_order',
        'status',
    ];

    protected $appends = [
        'created_at_human',
        'to_kitchen_human',
        'concessions_total',
    ];

    /**
     * @param mixed $value
     *
     * @return [type]
     */
    public function setToKitchenAttribute($value)
    {
        $this->attributes['to_kitchen'] = Carbon::parse($value)->format('Y-m-d H:i:00');
    }

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
    public function getToKitchenHumanAttribute()
    {
        return Carbon::parse($this->to_kitchen)->format('M d, Y h:i A');
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
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
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
