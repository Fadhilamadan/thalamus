<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
	protected $table = 'dokter';
	protected $fillable = ['id','nama_dokter','hapus','faskes_id'];

	public function getAllDokter()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllDokterbyID($id)
	{
		return $this->where('id', $id)->get();
	}

	public function getTotalDokter()
	{
		return $this->count();
	}


	/* -- Super Admin dan Admin Start --*/
	public function a_tambahNamaDokter($namaTempat, $namaDokter)
	{
		$tambahNamaDokter = new Dokter(array(
			'nama_dokter'	=> $namaDokter,
			'hapus' 		=> 0,
			'faskes_id'		=> $namaTempat,
		));
		$tambahNamaDokter->save();
	}

	public function a_updateNamaDokter($id, $namaDokter)
	{
		$data = $this->where('id', $id)->first();
		$data->nama_dokter = $namaDokter;
		$data->save();
	}

	public function a_statusDokter($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Super Admin dan Admin End --*/
}
