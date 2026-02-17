<?php

namespace Database\Seeders;

use App\Models\SemanaCasilla;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemanaCasillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semanas = [
            // Semanas año 2026
            ['anio' => 2026, 'numero_sem' => 1, 'descriptor' => 'Semana 1 (2-8 Enero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 2, 'descriptor' => 'Semana 2 (9-15 Enero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 3, 'descriptor' => 'Semana 3 (16-22 Enero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 4, 'descriptor' => 'Semana 4 (23-29 Enero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 5, 'descriptor' => 'Semana 5 (30 Enero - 5 Feb)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 6, 'descriptor' => 'Semana 6 (6-12 Febrero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 7, 'descriptor' => 'Semana 7 (13-19 Febrero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 8, 'descriptor' => 'Semana 8 (20-26 Febrero)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 9, 'descriptor' => 'Semana 9 (27 Feb - 5 Marzo)', 'precio' => 380.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 10, 'descriptor' => 'Semana 10 (6-12 Marzo)', 'precio' => 380.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 11, 'descriptor' => 'Semana 11 (13-19 Marzo)', 'precio' => 380.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 12, 'descriptor' => 'Semana 12 (20-26 Marzo)', 'precio' => 380.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 13, 'descriptor' => 'Semana 13 (27 Marzo - 2 Abril)', 'precio' => 450.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 14, 'descriptor' => 'Semana 14 (3-9 Abril)', 'precio' => 450.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 15, 'descriptor' => 'Semana 15 (10-16 Abril)', 'precio' => 450.00, 'estado' => 'libre'],
            
            // Verano - precios más altos
            ['anio' => 2026, 'numero_sem' => 25, 'descriptor' => 'Semana 25 (15-21 Junio)', 'precio' => 500.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 26, 'descriptor' => 'Semana 26 (22-28 Junio)', 'precio' => 550.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 27, 'descriptor' => 'Semana 27 (29 Junio - 5 Julio)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 28, 'descriptor' => 'Semana 28 (6-12 Julio)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 29, 'descriptor' => 'Semana 29 (13-19 Julio)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 30, 'descriptor' => 'Semana 30 (20-26 Julio)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 31, 'descriptor' => 'Semana 31 (27 Julio - 2 Agosto)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 32, 'descriptor' => 'Semana 32 (3-9 Agosto)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 33, 'descriptor' => 'Semana 33 (10-16 Agosto)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 34, 'descriptor' => 'Semana 34 (17-23 Agosto)', 'precio' => 600.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 35, 'descriptor' => 'Semana 35 (24-30 Agosto)', 'precio' => 550.00, 'estado' => 'libre'],
            
            // Otoño
            ['anio' => 2026, 'numero_sem' => 40, 'descriptor' => 'Semana 40 (28 Sept - 4 Octubre)', 'precio' => 400.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 41, 'descriptor' => 'Semana 41 (5-11 Octubre)', 'precio' => 400.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 42, 'descriptor' => 'Semana 42 (12-18 Octubre)', 'precio' => 400.00, 'estado' => 'libre'],
            
            // Invierno
            ['anio' => 2026, 'numero_sem' => 50, 'descriptor' => 'Semana 50 (7-13 Diciembre)', 'precio' => 350.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 51, 'descriptor' => 'Semana 51 (14-20 Diciembre)', 'precio' => 450.00, 'estado' => 'libre'],
            ['anio' => 2026, 'numero_sem' => 52, 'descriptor' => 'Navidad (21-27 Diciembre)', 'precio' => 550.00, 'estado' => 'libre'],
        ];

        foreach ($semanas as $semana) {
            SemanaCasilla::create($semana);
        }
    }
}
