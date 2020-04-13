<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
	protected $table = 'asuransi';
	protected $fillable = ['id','nama_asuransi','keterangan','hapus'];

	public function getAllAsuransi()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllAsuransibyID($id)
	{
		return $this->where('id', $id)->get();
	}

	public function getAllAsuransibyIDFitur($id)
	{
		return $this->whereIn('id', $id)->get();
	}


	/* -- Super Admin dan Admin Start --*/
	public function a_tambahNamaAsuransi($namaAsuransi, $keterangan)
	{
		$tambahNamaAsuransi = new Asuransi(array(
			'nama_asuransi' => $namaAsuransi,
			'keterangan' 	=> $keterangan,
			'hapus' 		=> 0,
		));
		$tambahNamaAsuransi->save();
	}

	public function a_updateNamaAsuransi($id, $namaAsuransi, $keterangan)
	{
		$data = $this->where('id', $id)->first();
		$data->nama_asuransi = $namaAsuransi;
		$data->keterangan	 = $keterangan;
		$data->save();
	}

	public function a_statusAsuransi($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Super Admin dan Admin End --*/
}