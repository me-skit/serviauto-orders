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
        $item->price = 45.00;
        $item->save();

        $item = new Item();
        $item->description = "Filtro de aceite de caja automática";
        $item->price = 190.00;
        $item->save();

        $item = new Item();
        $item->description = "Servicio a caja automática";
        $item->price = 225.00;
        $item->save();
    
        $item = new Item();
        $item->description = "Galón de gasolina";
        $item->price = 55.00;
        $item->save();

        $item = new Item();
        $item->description = "Servicio de cambio de aceite";
        $item->price = 150.00;
        $item->save();
    }
}
