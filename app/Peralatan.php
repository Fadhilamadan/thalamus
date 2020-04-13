<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
	protected $table = 'peralatan';
	protected $fillable = ['id','nama_peralatan','hapus'];

	public function getAllPeralatan()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllPeralatanbyID($id)
	{
		return $this->where('id', $id)->get();
	}


	/* -- Super Admin dan Admin Start --*/
	public function a_tambahNamaPeralatan($namaPeralatan)
	{
		$tambahNamaPeralatan = new Peralatan(array(
			'nama_peralatan'	=> $namaPeralatan,
			'hapus' 			=> 0,
		));
		$tambahNamaPeralatan->save();
	}

	public function a_updateNamaPeralatan($id, $namaPeralatan)
	{
		$data = $this->where('id', $id)->first();
		$data->nama_peralatan = $namaPeralatan;
		$data->save();
	}

	public function a_statusPeralatan($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Super Admin dan Admin End --*/
}