<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Price;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = new Item();
        $item->description = "Litro de aceite ATF-MV Evolution";
        $item->save();

        $price = new Price();
        $price->item_id = $item->id;
        $price->sell_price = 45.00;
        $price->save();

        $item = new Item();
        $item->description = "Filtro de aceite de caja automática";
        $item->save();

        $price = new Price();
        $price->item_id = $item->id;
        $price->sell_price = 190.00;
        $price->save();        

        $item = new Item();
        $item->description = "Servicio a caja automática";
        $item->save();

        $price = new Price();
        $price->item_id = $item->id;
        $price->sell_price = 225.00;
        $price->save();             
        
        $item = new Item();
        $item->description = "Galón de gasolina";
        $item->save();

        $price = new Price();
        $price->item_id = $item->id;
        $price->sell_price = 55.00;
        $price->save();          
        
        $item = new Item();
        $item->description = "Servicio de cambio de aceite";
        $item->save();
        
        $price = new Price();
        $price->item_id = $item->id;
        $price->sell_price = 150.00;
        $price->save();        
    }
}
