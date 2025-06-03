<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['location', 'address', 'phone', 'created_by', 'updated_by'];

    public function getFormattedPhoneAttribute()
    {
        $variable = str_split($this->phone, 4);
        $formatted = $variable[0] . ' ' . $variable[1];
        return $formatted;
    }
}
