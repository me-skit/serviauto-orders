<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'brand', 'line', 'year', 'color', 'plate', 'created_by', 'updated_by'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getDescriptionAttribute()
    {
        return $this->brand . ' ' . $this->line . ' ' . $this->color . ', año '. $this->year . ', ' . $this->plate;
    }
}
