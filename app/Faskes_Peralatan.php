<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faskes_Peralatan extends Model
{
	protected $table = 'faskes_has_peralatan';
	protected $fillable = ['faskes_id','peralatan_id','keterangan'];

	public function faskes()
	{
		return $this->belongsTo('App\Faskes','faskes_id');
	}

	public function peralatan()
	{
		return $this->belongsTo('App\Peralatan','peralatan_id');
	}

	public function getAllbyIDFaskes($id)
	{
		return $this->where('faskes_id', $id)->get();
	}


	/* -- Admin Start --*/
	public function a_insertPeralatan($faskes, $peralatan, $keterangan)
	{
		$insertPeralatan = new Faskes_Peralatan(array(
			'faskes_id' 	=> $faskes,
			'peralatan_id'  => $peralatan,
			'keterangan'    => $keterangan,
		));
		$insertPeralatan->save();
	}

	public function a_deletePeralatan($faskes, $peralatan)
	{
		return $this->where('faskes_id', $faskes)->where('peralatan_id', $peralatan)->delete();
	}
	/* -- Admin End --*/
}