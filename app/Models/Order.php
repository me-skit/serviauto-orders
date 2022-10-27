<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'car_description', 'price_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot(['quantity', 'price_id'])->using(ItemOrder::class);
        
    }

    public function getTotalAttribute()
    {
        $total = DB::select(DB::raw("SELECT SUM(item_order.quantity * prices.sell_price) as cents
                                           FROM item_order
                                           JOIN prices ON item_order.price_id = prices.id
                                           WHERE item_order.order_id = ?"), [$this->id]);

        return "Q " .  number_format($total[0]->cents / 100, 2, '.', ',');
    }

    public function getItemsOrderAttribute()
    {
        $prices_list = DB::select(DB::raw("SELECT prices_list.*, items.description
                                           FROM (SELECT item_order.item_id, item_order.price_id, item_order.quantity, (prices.sell_price / 100) as sell_price
                                                 FROM item_order
                                                 JOIN prices ON item_order.price_id = prices.id
                                                 WHERE item_order.order_id = ?) AS prices_list
                                           JOIN items ON prices_list.item_id = items.id"), [$this->id]);

        return $prices_list;
    }    
}
