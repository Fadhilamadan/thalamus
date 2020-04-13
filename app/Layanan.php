<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
	protected $table = 'layanan';
	protected $fillable = ['id','nama_layanan','hapus'];

	public function getAllLayanan()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllLayananbyID($id)
	{
		return $this->where('id', $id)->get();
	}

	public function getAllLayananbyIDFitur($id)
	{
		return $this->whereIn('id', $id)->get();
	}


	/* -- Super Admin dan Admin Start --*/
	public function a_tambahNamaLayanan($namaLayanan)
	{
		$tambahNamaLayanan = new Layanan(array(
			'nama_layanan'	=> $namaLayanan,
			'hapus' 		=> 0,
		));
		$tambahNamaLayanan->save();
	}

	public function a_updateNamaLayanan($id, $namaLayanan)
	{
		$data = $this->where('id', $id)->first();
		$data->nama_layanan	= $namaLayanan;
		$data->save();
	}

	public function a_statusLayanan($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Super Admin dan Admin End --*/
}