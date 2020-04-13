<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';
	protected $fillable = ['id','nama_pengguna','ulasan','rating_faskes','rating_layanan','hapus','faskes_id'];

	public function getAllUlasan()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllUlasanbyID($id)
	{
		return $this->where('id', $id)->get();
	}

	
	/* -- Public Start --*/
	public function insertUlasan($id, $nama_pengguna, $ulasan, $rating_faskes, $rating_layanan)
	{
		$insertUlasan = new Ulasan(array(
			'nama_pengguna' => $nama_pengguna,
			'ulasan' 		=> $ulasan,
			'rating_faskes' => $rating_faskes,
			'rating_layanan'=> $rating_layanan,
			'hapus' 		=> 1,
			'faskes_id' 	=> $id,
		));
		$insertUlasan->save();
	}
	/* -- Public End --*/


	/* -- Super Admin Start --*/
	public function a_statusUlasanSuper($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Super Admin End --*/
}
