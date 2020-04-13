<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
	protected $table = 'penyakit';
	protected $fillable = ['id','nama_penyakit','hapus'];

	public function getAllPenyakit()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllPenyakitbyID($id)
	{
		return $this->where('id', $id)->get();
	}

	/* -- Super Admin dan Admin Start --*/
	public function a_tambahNamaPenyakit($namaPenyakit)
	{
		$tambahNamaPenyakit = new Penyakit(array(
			'nama_penyakit'	=> $namaPenyakit,
			'hapus' 		=> 0,
		));
		$tambahNamaPenyakit->save();
	}

	public function a_updateNamaPenyakit($id, $namaPenyakit)
	{
		$data = $this->where('id', $id)->first();
		$data->nama_penyakit = $namaPenyakit;
		$data->save();
	}

	public function a_statusPenyakit($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Super Admin dan Admin End --*/
}