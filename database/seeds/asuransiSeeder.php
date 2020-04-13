<?php

use Illuminate\Database\Seeder;

class asuransiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$asuransi_data=[ 

    		['id'=>'1',
    		'nama_asuransi'=>'BPJS Kesehatan',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'2',
    		'nama_asuransi'=>'Prudential Life Assurance',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'3',
    		'nama_asuransi'=>'Sinarmas MSIG',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'4',
    		'nama_asuransi'=>'Allianz Life',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'5',
    		'nama_asuransi'=>'Manulife Indonesia',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'6',
    		'nama_asuransi'=>'AIA Financial',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'7',
    		'nama_asuransi'=>'AXA Mandiri Financial Service',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0'],

    		['id'=>'8',
    		'nama_asuransi'=>'Panin Life',
            'keterangan'=>'Coba Tester',
    		'hapus'=>'0']

    	];
    	DB::table('asuransi')->insert($asuransi_data);
    }
}
