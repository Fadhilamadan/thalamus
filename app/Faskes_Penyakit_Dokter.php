<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faskes_Penyakit_Dokter extends Model
{
	protected $table = 'faskes_has_penyakit_has_dokter';
	protected $fillable = ['faskes_id','penyakit_id','dokter_id'];

	public function faskes()
	{
		return $this->belongsTo('App\Faskes','faskes_id');
	}

	public function penyakit()
	{
		return $this->belongsTo('App\Penyakit','penyakit_id');
	}

	public function dokter()
	{
		return $this->belongsTo('App\Dokter','dokter_id');
	}

	public function getAllbyIDFaskes($id)
	{
		return $this->where('faskes_id', $id)->get();
	}
	

	/* -- Admin Start --*/
	public function a_insertDokter($faskes, $penyakit, $dokter)
	{
		foreach ($penyakit as $key => $value) {
			$insertDokter = new Faskes_Penyakit_Dokter(array(
				'faskes_id' => $faskes,
				'penyakit_id' => $value,
				'dokter_id' => $dokter,
			));
			$insertDokter->save();
		}
	}

	public function a_deleteDokter($faskes, $dokter)
	{
		return $this->where('faskes_id', $faskes)->where('dokter_id', $dokter)->delete();
	}
	/* -- Admin End --*/
}
