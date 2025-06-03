<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location_id', 'phone_number', 'created_by', 'updated_by'];

    public function Location()
    {
        return $this->belongsTo(Location::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->whereNull('finished')->orderBy('id', 'desc');
    }

    public function historic()
    {
        return $this->hasMany(Order::class)->whereNotNull('finished')->orderBy('id', 'desc');
    }

    public function cars()
    {
        return $this->hasMany(Car::class)->orderBy('id', 'desc');
    }
}
