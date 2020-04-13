<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pencarian_TFIDF extends Model
{
	protected $table = 'pencarian_tfidf';
	protected $fillable = ['faskes_id','kata','jumlah'];

	public function getAllDataByFaskesId($id)
	{
		$temp = $this->where('faskes_id', $id)->get();
		$result = array();
		foreach($temp as $data)
		{
			$result[] = $data->kata;
		}
		return $result;
	}

	public function a_insertTFIDF($id, $kata, $jumlah)
	{
		$insertTFIDF = new Pencarian_TFIDF(array(
			'faskes_id'	=> $id,
			'kata' 		=> $kata,
			'jumlah' 	=> $jumlah,
		));
		$insertTFIDF->save();
	}

	public function a_insertTFIDFfitur($id, $kata, $jumlah)
	{
		$insertTFIDF = new Pencarian_TFIDF(array(
			'faskes_id'	=> $id,
			'kata' 		=> $kata,
			'jumlah' 	=> $jumlah,
		));
		$insertTFIDF->save();
	}
	
	public function a_updateTFIDF($faskes_id, $kata, $jumlah)
	{
		Pencarian_TFIDF::where('faskes_id', $faskes_id)->where('kata', '' . $kata)->update(['jumlah' => $jumlah]);
	}

	public function a_deleteTFIDF($faskes_id)
	{
		Pencarian_TFIDF::where('faskes_id', $faskes_id)->delete();
	}

	public function a_deleteTFIDFByKata($faskes_id, $kata)
	{
		Pencarian_TFIDF::where('faskes_id', $faskes_id)->where('kata', $kata)->delete();
	}
}