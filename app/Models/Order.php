<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'car_id', 'date', 'finished'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }

    public function getTotalAttribute()
    {
        $total = DB::select(DB::raw("SELECT SUM(order_items.quantity * order_items.price) AS cents
                                     FROM order_items
                                     WHERE order_items.order_id = ?"), [$this->id]);

        return "Q " .  number_format($total[0]->cents / 100, 2, '.', ',');
    }

    // static methods

    public static function totalByClientOrders($client_id)
    {
        $total = DB::select(DB::raw("SELECT SUM(order_items.quantity * order_items.price) AS cents
                                     FROM order_items
                                     WHERE order_items.order_id IN (SELECT id AS order_id
                                                                    FROM orders
                                                                    WHERE orders.client_id = ?
                                                                        AND orders.finished IS NULL)"), [$client_id]);

        return "Q " .  number_format($total[0]->cents / 100, 2, '.', ',');
    }
}
