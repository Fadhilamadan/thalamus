<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faskes_Asuransi extends Model
{
	protected $table = 'faskes_has_asuransi';
	protected $fillable = ['faskes_id','asuransi_id'];

	public function faskes()
	{
		return $this->belongsTo('App\Faskes','faskes_id');
	}

	public function asuransi()
	{
		return $this->belongsTo('App\Asuransi','asuransi_id');
	}

	public function getAllbyIDFaskes($id)
    {
        return $this->where('faskes_id', $id)->get();
    }
    

	/* -- Super Admin dan Admin Start --*/
	public function a_insertAsuransi($faskes, $asuransi)
	{
		foreach ($asuransi as $key => $value) {
			$insertAsuransi = new Faskes_Asuransi(array(
				'faskes_id' => $faskes,
				'asuransi_id' => $value,
			));
			$insertAsuransi->save();
		}
	}

	public function a_deleteAsuransi($faskes)
	{
		return $this->where('faskes_id', $faskes)->delete();
	}
	/* -- Super Admin dan Admin Start --*/
}
