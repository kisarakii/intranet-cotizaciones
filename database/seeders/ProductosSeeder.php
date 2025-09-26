<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['sku' => 'P-0001', 'nombre' => 'Teclado Mecánico',     'precio_unitario' => 199.90],
            ['sku' => 'P-0002', 'nombre' => 'Mouse Inalámbrico',    'precio_unitario' => 89.50],
            ['sku' => 'P-0003', 'nombre' => 'Monitor 24" 1080p',    'precio_unitario' => 799.00],
            ['sku' => 'P-0004', 'nombre' => 'Silla Ergonómica',     'precio_unitario' => 1299.00],
            ['sku' => 'P-0005', 'nombre' => 'Headset Over-Ear',     'precio_unitario' => 249.00],
            ['sku' => 'P-0006', 'nombre' => 'Hub USB-C 7 en 1',     'precio_unitario' => 159.99],
            ['sku' => 'P-0007', 'nombre' => 'SSD 1TB NVMe',         'precio_unitario' => 499.00],
            ['sku' => 'P-0008', 'nombre' => 'Base Refrigeración',   'precio_unitario' => 119.00],
        ];

        foreach ($items as $it) {
            Producto::updateOrCreate(['sku' => $it['sku']], $it);
        }
    }
}
