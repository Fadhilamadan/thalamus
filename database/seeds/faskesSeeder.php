<?php

use Illuminate\Database\Seeder;

class faskesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faskes_data=[ 

    		['id'=>'1',
    		'nama_tempat'=>'Rumah Sakit Premier Surabaya',
    		'alamat'=>'Jalan Nginden Intan Barat Blok B, Nginden Jangkungan, Sukolilo, Kota SBY, Jawa Timur 60118',
            'deskripsi'=>'Fasilitas layanan unggulan yang telah dikembangkan baik sejak awal maupun dalam perjalanan memberikan layanan kepada pelanggan. Dokter spesialis di Rumah Sakit Premier Surabaya semuanya telah mendapat akreditasi dari Medical Advisory Committee. Pelayanan dan konsultasi langsung yang diberikan oleh dokter spesialis kami, dilengkapi dengan tim dokter jaga yang berada di rumah sakit 24 jam setiap hari, untuk menangani pasien di Unit Gawat Darurat',
            'telepon'=>'0315993211',
            'jam_buka'=>'00:00:00',
            'jam_tutup'=>'00:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Minggu',    		
            'latitude'=>'-7.3045793',
            'longitude'=>'112.7651326',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'2',
            'nama_tempat'=>'Rumah Sakit Royal Surabaya',
            'alamat'=>'Jalan Kendangsari Industri No.1, Kendangsari, Tenggilis Mejoyo, Kendangsari, Tenggilis Mejoyo, Kota SBY, Jawa Timur 60292',
            'deskripsi'=>'Layanan unggulan di bagian Bedah Thorax dan Kateterisasi Jantung & Angiografi (CATHLAB)',
            'telepon'=>'0318476111',
            'jam_buka'=>'00:00:00',
            'jam_tutup'=>'00:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Minggu',
            'latitude'=>'-7.3292317',
            'longitude'=>'112.7506045',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'3',
            'nama_tempat'=>'Dr. Evy Ervianti',
            'alamat'=>'Rungkut Mejoyo Selatan No.1, Kali Rungkut, Rungkut, Kali Rungkut, Rungkut, Kota SBY, Jawa Timur 60292',
            'deskripsi'=>'Dokter Spesialis Kulit dan Kelamin',
            'telepon'=>'0318476111',
            'jam_buka'=>'18:30:00',
            'jam_tutup'=>'20:30:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Jumat',
            'latitude'=>'-7.3211981',
            'longitude'=>'112.7623141',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'4',
            'nama_tempat'=>'Bidan Delima Ny. Endang M.Adji',
            'alamat'=>'Jl. Rungkut Mejoyo Selatan VI No.10-18, Kali Rungkut, Rungkut, Kota SBY, Jawa Timur 60293',
            'deskripsi'=>'Rumah untuk bersalin anak yang sudah berpengalaman sejak 2007 hingga sekarang',
            'telepon'=>'0318474991',
            'jam_buka'=>'00:00:00',
            'jam_tutup'=>'00:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Jumat',
            'latitude'=>'-7.323558',
            'longitude'=>'112.761775',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'5',
            'nama_tempat'=>'Bidan Praktek Swasta Endang Mawarsih Amd.Keb',
            'alamat'=>'Jl. Rungkut Mejoyo Selatan VI, Kali Rungkut, Rungkut, Kota SBY, Jawa Timur 60293',
            'deskripsi'=>'Rumah untuk bersalin anak',
            'telepon'=>'0318474991',
            'jam_buka'=>'00:00:00',
            'jam_tutup'=>'00:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Jumat',
            'latitude'=>'-7.323592',
            'longitude'=>'112.763412',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'6',
            'nama_tempat'=>'Puskesmas Tenggilis',
            'alamat'=>'Jalan Rungkut Mejoyo Selatan IV/P-48, Kecamatan Kalirungkut, Kali Rungkut, Rungkut, Kota SBY, Jawa Timur 60293',
            'deskripsi'=>'Melayani berbagai penyakit-penyakit ringan',
            'telepon'=>'0318490234',
            'jam_buka'=>'07:30:00',
            'jam_tutup'=>'16:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Sabtu',
            'latitude'=>'-7.32257',
            'longitude'=>'112.762048',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'7',
            'nama_tempat'=>'Apotek Viva Generik',
            'alamat'=>'Jl. Raya Kalirungkut No. 70B, RT. 02/RW. 07, Kali Rungkut, Rungkut, Kali Rungkut, Rungkut, Kota SBY, Jawa Timur 60293, Indonesia',
            'deskripsi'=>'Menyediakan berbagai macam obat-obatan, dari ringan hingga menggunakan resep dokter',
            'telepon'=>'0318415167',
            'jam_buka'=>'08:00:00',
            'jam_tutup'=>'21:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Minggu',
            'latitude'=>'-7.3193641',
            'longitude'=>'112.7637253',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'8',
            'nama_tempat'=>'Apotik Savira',
            'alamat'=>'JL. Tenggilis Utara 2, No. 12, Kendangsari, Tenggilis Mejoyo, 60292, Tenggilis Mejoyo, Kota SBY, Jawa Timur 60292, Indonesia',
            'deskripsi'=>'Menyediakan berbagai macam obat-obatan, dari ringan hingga menggunakan resep dokter',
            'telepon'=>'0318418652',
            'jam_buka'=>'07:30:00',
            'jam_tutup'=>'21:30:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Minggu',
            'latitude'=>'-7.3174492',
            'longitude'=>'112.7568687',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'9',
            'nama_tempat'=>'Apotik Setia Budi',
            'alamat'=>'Jl. Raya Rungkut Madya No.141, Kali Rungkut, Rungkut, Kota SBY, Jawa Timur 60293, Indonesia',
            'deskripsi'=>'Apotik Setia Budi menyediakan berbagai macam obat-obatan, dari ringan hingga menggunakan resep dokter',
            'telepon'=>'0318795055',
            'jam_buka'=>'07:30:00',
            'jam_tutup'=>'21:30:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Minggu',
            'latitude'=>'-7.3148555',
            'longitude'=>'112.7669593',
            'hapus'=>'0',
            'users_id'=>'1'],

            ['id'=>'10',
            'nama_tempat'=>'Praktek Dokter Gigi Ria Srijanti',
            'alamat'=>'Jl. Tenggilis Mejoyo Selatan III No.36, Tenggilis Mejoyo, Kota SBY, Jawa Timur 60292, Indonesia',
            'deskripsi'=>'Merawat berbagai macam masalah pada gigi',
            'telepon'=>'0318420224',
            'jam_buka'=>'08:00:00',
            'jam_tutup'=>'19:00:00',
            'hari_buka'=>'Senin',
            'hari_tutup'=>'Jumat',
            'latitude'=>'-7.324394',
            'longitude'=>'112.7603779',
            'hapus'=>'0',
            'users_id'=>'1']

        ];
        DB::table('faskes')->insert($faskes_data);
    }
}
