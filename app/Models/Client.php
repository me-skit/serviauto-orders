<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'created_by', 'updated_by'];

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
