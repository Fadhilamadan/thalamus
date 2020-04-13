<?php

use Illuminate\Database\Seeder;

class dokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$dokter_data=[ 

    		['id'=>'1',
    		'nama_dokter'=>'dr. Bobby N. Nelwan, SpOT',
    		'hapus'=>'0'],

    		['id'=>'2',
    		'nama_dokter'=>'dr. Fenny Yunita, M.Si',
    		'hapus'=>'0'],

    		['id'=>'3',
    		'nama_dokter'=>'dr. Henry L. Santosa, SpB',
    		'hapus'=>'0'],

    		['id'=>'4',
    		'nama_dokter'=>'dr. Oktaviati, SpB',
    		'hapus'=>'0'],

    		['id'=>'5',
    		'nama_dokter'=>'drg. Mochamad Zain',
    		'hapus'=>'0'],

    		['id'=>'6',
    		'nama_dokter'=>'drg. Kirti Indru Moorjani',
    		'hapus'=>'0'],

    		['id'=>'7',
    		'nama_dokter'=>'dr. IGM Febry Siswanto, SpOT',
    		'hapus'=>'0'],

    		['id'=>'8',
    		'nama_dokter'=>'dr. Anna Steven',
    		'hapus'=>'0'],

    		['id'=>'9',
    		'nama_dokter'=>'DR. dr. Rika Haryono, SpKO',
    		'hapus'=>'0'],

    		['id'=>'10',
    		'nama_dokter'=>'dr. Sebastianus Jobul, SpPD-KEMD, FINASIM',
    		'hapus'=>'0']

    	];
    	DB::table('dokter')->insert($dokter_data);
    }
}
