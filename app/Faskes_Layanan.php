<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faskes_Layanan extends Model
{
	protected $table = 'faskes_has_layanan';
	protected $fillable = ['faskes_id','layanan_id'];

	public function faskes()
	{
		return $this->belongsTo('App\Faskes','faskes_id');
	}

	public function layanan()
	{
		return $this->belongsTo('App\Layanan','layanan_id');
	}

	public function getAllbyIDFaskes($id)
	{
		return $this->where('faskes_id', $id)->get();
	}
	

	/* -- Super Admin dan Admin Start --*/
	public function a_insertLayanan($faskes, $layanan)
	{
		foreach ($layanan as $key => $value) {
			$insertLayanan = new Faskes_Layanan(array(
				'faskes_id' => $faskes,
				'layanan_id' => $value,
			));
			$insertLayanan->save();
		}
	}

	public function a_deleteLayanan($faskes)
	{
		return $this->where('faskes_id', $faskes)->delete();
	}
	/* -- Super Admin dan Admin Start --*/
}