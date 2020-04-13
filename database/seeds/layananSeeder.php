<?php

use Illuminate\Database\Seeder;

class layananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layanan_data=[ 

    		['id'=>'1',
    		'nama_layanan'=>'Unit Gawat Darurat',
    		'hapus'=>'0'],

    		['id'=>'2',
    		'nama_layanan'=>'Radiologi',
    		'hapus'=>'0'],

    		['id'=>'3',
    		'nama_layanan'=>'Endoskopi',
    		'hapus'=>'0'],

    		['id'=>'4',
    		'nama_layanan'=>'EKG',
    		'hapus'=>'0'],

    		['id'=>'5',
    		'nama_layanan'=>'Hemodialisa',
    		'hapus'=>'0'],

    		['id'=>'6',
    		'nama_layanan'=>'Echocardiography',
    		'hapus'=>'0'],

            ['id'=>'7',
            'nama_layanan'=>'Rontgen & CT Scan',
            'hapus'=>'0'],

            ['id'=>'8',
            'nama_layanan'=>'Medical Check Up',
            'hapus'=>'0']

    	];
    	DB::table('layanan')->insert($layanan_data);
    }
}
