<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleEventSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('booths')->insertBatch([
            ['name'=>'Coffee Corner','location'=>'A1','description'=>'Specialty coffee booth'],
            ['name'=>'Merch Stand','location'=>'B3','description'=>'Band merch & shirts']
        ]);

        $this->db->table('singers')->insertBatch([
            ['name'=>'Luna Sky','genre'=>'Indie Pop','performance_date'=>'2026-01-15 18:30:00','bio'=>'Rising indie artist.'],
            ['name'=>'The Daybreak','genre'=>'Rock','performance_date'=>'2026-01-16 20:00:00','bio'=>'Energetic rock band.']
        ]);

        $this->db->table('tickets')->insertBatch([
            ['type'=>'General Admission','price'=>'500.00','available'=>200,'description'=>'Standing area'],
            ['type'=>'VIP','price'=>'1500.00','available'=>50,'description'=>'Front row + freebies']
        ]);
    }
}
