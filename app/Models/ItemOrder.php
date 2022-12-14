<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemOrder extends Pivot
{
    public function price()
    {
        return $this->belongsTo(Price::class);
    }
}
