<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/beranda', 'HomeController@beranda');

/*-- Public Start --*/
Route::get('/', 'publicController@indexPublic');
Route::resource('submit', 'publicController');
Route::post('/insertFaskes', 'publicController@insertFaskes');
Route::post('/search', 'publicController@search');
Route::post('/searchAdvanced', 'publicController@searchAdvanced');
Route::post('/search_detail', 'publicController@searchDetail');
Route::post('/insertUlasan', 'publicController@insertUlasan');
/*-- Public End --*/


/*-- Admin Start --*/
Route::middleware('role:admin')->group(function() {
	Route::get('/kesehatan_daftar', 'HomeController@kesehatanDaftar');
	Route::get('/kesehatan_tambah', 'HomeController@kesehatanTambah');
	Route::post('/kesehatan_maps', 'HomeController@kesehatanMaps');
	Route::post('/insertFasKes', 'HomeController@insertFasKes');
	Route::post('/updateFaskes','HomeController@updateFaskes');
	Route::post('/updateMap','HomeController@updateMap');
	Route::post('/statusFaskes', 'HomeController@statusFaskes');

	Route::get('/layanan_daftar', 'HomeController@layananDaftar');
	Route::get('/layanan_tambah', 'HomeController@layananTambah');
	Route::post('/insertLayanan', 'HomeController@insertLayanan');
	Route::post('/updateLayanan','HomeController@updateLayanan');
	Route::post('/tambahNamaLayanan', 'HomeController@tambahNamaLayanan');

	Route::get('/asuransi_daftar', 'HomeController@asuransiDaftar');
	Route::get('/asuransi_tambah', 'HomeController@asuransiTambah');
	Route::post('/insertAsuransi', 'HomeController@insertAsuransi');
	Route::post('/updateAsuransi','HomeController@updateAsuransi');
	Route::post('/tambahNamaAsuransi', 'HomeController@tambahNamaAsuransi');

	Route::get('/dokter_daftar', 'HomeController@dokterDaftar');
	Route::get('/dokter_tambah', 'HomeController@dokterTambah');
	Route::post('/insertDokter', 'HomeController@insertDokter');
	Route::post('/updateDokter','HomeController@updateDokter');
	Route::post('/tambahNamaDokter', 'HomeController@tambahNamaDokter');
	Route::get('/dataDokter','HomeController@dataDokter');

	Route::post('/tambahNamaPenyakit', 'HomeController@tambahNamaPenyakit');
	Route::get('/dataPenyakit','HomeController@dataPenyakit');

	Route::get('/peralatan_daftar', 'HomeController@peralatanDaftar');
	Route::get('/peralatan_tambah', 'HomeController@peralatanTambah');
	Route::post('/insertPeralatan', 'HomeController@insertperalatan');
	Route::post('/updatePeralatan','HomeController@updatePeralatan');
	Route::post('/tambahNamaPeralatan', 'HomeController@tambahNamaPeralatan');
	Route::get('/dataPeralatan','HomeController@dataPeralatan');
});
/*-- Admin End --*/


/*-- Super Admin Start --*/
Route::middleware('role:superadmin')->group(function() {
	Route::get('/kesehatan_daftar_super', 'HomeController@kesehatanDaftar_super');
	Route::get('/kesehatan_tambah_super', 'HomeController@kesehatanTambah_super');
	Route::post('/kesehatanMaps_super', 'HomeController@kesehatanMaps_super');
	Route::post('/insertFasKes_super', 'HomeController@insertFasKes_super');
	Route::post('/updateFaskes_super','HomeController@updateFaskes_super');
	Route::post('/updateMap_super','HomeController@updateMap_super');
	Route::post('/statusFaskes_super', 'HomeController@statusFaskes_super');

	Route::get('/layanan_daftar_super', 'HomeController@layananDaftar_super');
	Route::get('/layanan_tambah_super', 'HomeController@layananTambah_super');
	Route::get('/layanan_data_super', 'HomeController@layananData_super');
	Route::post('/insertLayanan_super', 'HomeController@insertLayanan_super');
	Route::post('/updateLayanan_super','HomeController@updateLayanan_super');
	Route::post('/tambahNamaLayanan_super', 'HomeController@tambahNamaLayanan_super');
	Route::post('/updateNamaLayanan_super', 'HomeController@updateNamaLayanan_super');
	Route::post('/statusLayanan_super', 'HomeController@statusLayanan_super');

	Route::get('/asuransi_daftar_super', 'HomeController@asuransiDaftar_super');
	Route::get('/asuransi_tambah_super', 'HomeController@asuransiTambah_super');
	Route::get('/asuransi_data_super', 'HomeController@asuransiData_super');
	Route::post('/insertAsuransi_super', 'HomeController@insertAsuransi_super');
	Route::post('/updateAsuransi_super','HomeController@updateAsuransi_super');
	Route::post('/tambahNamaAsuransi_super', 'HomeController@tambahNamaAsuransi_super');
	Route::post('/updateNamaAsuransi_super', 'HomeController@updateNamaAsuransi_super');
	Route::post('/statusAsuransi_super', 'HomeController@statusAsuransi_super');

	Route::get('/dokter_daftar_super', 'HomeController@dokterDaftar_super');
	Route::get('/dokter_tambah_super', 'HomeController@dokterTambah_super');
	Route::get('/dokter_data_super', 'HomeController@dokterData_super');
	Route::post('/insertDokter_super', 'HomeController@insertDokter_super');
	Route::post('/updateDokter_super','HomeController@updateDokter_super');
	Route::post('/tambahNamaDokter_super', 'HomeController@tambahNamaDokter_super');
	Route::post('/updateNamaDokter_super', 'HomeController@updateNamaDokter_super');
	Route::post('/statusDokter_super', 'HomeController@statusDokter_super');
	Route::get('/dataDokter_super','HomeController@dataDokter_super');

	Route::get('/penyakit_data_super', 'HomeController@penyakitData_super');
	Route::post('/tambahNamaPenyakit_super', 'HomeController@tambahNamaPenyakit_super');
	Route::post('/updateNamaPenyakit_super', 'HomeController@updateNamaPenyakit_super');
	Route::post('/statusPenyakit_super', 'HomeController@statusPenyakit_super');
	Route::get('/dataPenyakit_super','HomeController@dataPenyakit_super');

	Route::get('/peralatan_daftar_super', 'HomeController@peralatanDaftar_super');
	Route::get('/peralatan_tambah_super', 'HomeController@peralatanTambah_super');
	Route::get('/peralatan_data_super', 'HomeController@peralatanData_super');
	Route::post('/insertPeralatan_super', 'HomeController@insertperalatan_super');
	Route::post('/updatePeralatan_super','HomeController@updatePeralatan_super');
	Route::post('/tambahNamaPeralatan_super', 'HomeController@tambahNamaPeralatan_super');
	Route::post('/updateNamaPeralatan_super', 'HomeController@updateNamaPeralatan_super');
	Route::post('/statusPeralatan_super', 'HomeController@statusPeralatan_super');
	Route::get('/dataPeralatan_super','HomeController@dataPeralatan_super');

	Route::get('/ulasan_super', 'HomeController@ulasan_super');
	Route::post('/statusUlasan_super', 'HomeController@statusUlasan_super');
});
/*-- Super Admin End --*/