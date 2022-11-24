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
        $item->cost = 35.00;
        $item->price = 45.00;
        $item->stock = 100;
        $item->save();

        $item = new Item();
        $item->description = "Filtro de aceite de caja automática";
        $item->cost = 150.00;
        $item->price = 190.00;
        $item->stock = 100;
        $item->save();

        $item = new Item();
        $item->description = "Servicio a caja automática";
        $item->cost = 200.00;
        $item->price = 225.00;
        $item->stock = 100;
        $item->save();
    
        $item = new Item();
        $item->description = "Galón de gasolina";
        $item->cost = 40.00;
        $item->price = 55.00;
        $item->stock = 100;
        $item->save();

        $item = new Item();
        $item->description = "Servicio de cambio de aceite";
        $item->cost = 110.00;
        $item->price = 150.00;
        $item->stock = 100;
        $item->save();
    }
}
