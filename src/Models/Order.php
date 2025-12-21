<?php

namespace Mvcomp\Posapp\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total'
    ];

    public $timestamps = true;

    protected $casts = [
        'total' => 'decimal:2'
    ];

    /* =====================
    | RELATIONS
     ===================== */

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function recalculateTotal(): void
    {
        $this->total = $this->items
            ->sum(fn($item) => $item->qty * $item->price);

        $this->save();
    }
}
