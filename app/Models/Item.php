<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'cost', 'price', 'stock'];

    public function getCostAttribute($value)
    {
        return $value ? $value / 100 : null;
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setCostAttribute($value)
    {
        $this->attributes['cost'] = $value ? $value * 100 : null;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function getFormattedCostAttribute()
    {
        return $this->cost ? "Q " .  number_format($this->cost, 2, '.', ',') : "";
    }

    public function getFormattedPriceAttribute()
    {
        return "Q " .  number_format($this->price, 2, '.', ',');
    }
}
