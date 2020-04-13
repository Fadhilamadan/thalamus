<?php

use Illuminate\Database\Seeder;

class penyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$penyakit_data=[ 

    		['id'=>'1',
    		'nama_penyakit'=>'Jantung Koroner',
    		'hapus'=>'0'],

    		['id'=>'2',
    		'nama_penyakit'=>'Stroke',
    		'hapus'=>'0'],

    		['id'=>'3',
    		'nama_penyakit'=>'ISPA',
    		'hapus'=>'0'],

    		['id'=>'4',
    		'nama_penyakit'=>'Komplikasi Perinatal',
    		'hapus'=>'0'],

    		['id'=>'5',
    		'nama_penyakit'=>'Diare',
    		'hapus'=>'0'],

    		['id'=>'6',
    		'nama_penyakit'=>'Tuberkulosis',
    		'hapus'=>'0'],

    		['id'=>'7',
    		'nama_penyakit'=>'Malaria',
    		'hapus'=>'0'],

    		['id'=>'8',
    		'nama_penyakit'=>'Kanker',
    		'hapus'=>'0'],

    		['id'=>'9',
    		'nama_penyakit'=>'PPOK',
    		'hapus'=>'0'],

    		['id'=>'10',
    		'nama_penyakit'=>'Leukimia',
    		'hapus'=>'0'],

    		['id'=>'11',
    		'nama_penyakit'=>'Ebola',
    		'hapus'=>'0'],

    		['id'=>'12',
    		'nama_penyakit'=>'Tumor Otak',
    		'hapus'=>'0'],

    		['id'=>'13',
    		'nama_penyakit'=>'Jantung',
    		'hapus'=>'0'],

    		['id'=>'14',
    		'nama_penyakit'=>'Flu Babi',
    		'hapus'=>'0'],

    		['id'=>'15',
    		'nama_penyakit'=>'Flu Burung',
    		'hapus'=>'0'],

    		['id'=>'16',
    		'nama_penyakit'=>'Kencing Manis',
    		'hapus'=>'0'],

    		['id'=>'17',
    		'nama_penyakit'=>'Kolera',
    		'hapus'=>'0'],

    		['id'=>'18',
    		'nama_penyakit'=>'Hepatitis',
    		'hapus'=>'0'],

    		['id'=>'19',
    		'nama_penyakit'=>'Meningitis',
    		'hapus'=>'0'],

    		['id'=>'20',
    		'nama_penyakit'=>'Batuk Rejan',
    		'hapus'=>'0']

    	];
    	DB::table('penyakit')->insert($penyakit_data);
    }
}
