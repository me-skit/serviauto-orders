<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'brand', 'line', 'year', 'color', 'engine_number', 'cc', 'chassis_number', 'next_service', 'service_id', 'created_by', 'updated_by'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Order::class, 'service_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getDescriptionAttribute()
    {
        return $this->brand . ' ' . $this->line . ' ' . $this->color . ', año '. $this->year . ', ' . $this->plate;
    }

    public function setNextServiceAttribute($value)
    {
        $this->attributes['next_service'] = $value ? str_replace(',', '', $value) : null;
    }

    public function setCcAttribute($value)
    {
        $this->attributes['cc'] = $value ? str_replace(',', '', $value) : null;
    }
}
