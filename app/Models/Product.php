<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'presentation',
        'initial_qty',
        'current_qty',
        'min_stock',
        'photo',
    ];

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
    //
}
