<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'cost', 'sell_price'];

    public function getCostAttribute()
    {
        return $this->attributes['cost'] ? $this->attributes['cost'] / 100 : null;
    }

    public function getSellPriceAttribute()
    {
        return $this->attributes['sell_price'] / 100;
    }

    public function setCostAttribute($value)
    {   
        $this->attributes['cost'] = $value ? $value * 100 : null;
    }

    public function setSellPriceAttribute($value)
    {
        $this->attributes['sell_price'] = $value * 100;
    }

    public function getCostCurrencyFormatAttribute()
    {
        return $this->cost ? "Q " .  number_format($this->cost, 2, '.', ',') : "";
    }

    public function getPriceCurrencyFormatAttribute()
    {
        return "Q " .  number_format($this->sell_price, 2, '.', ',');
    }
}
