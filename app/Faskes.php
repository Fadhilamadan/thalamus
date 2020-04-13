<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Faskes_Asuransi;
use App\Faskes_Layanan;
use App\Faskes_Peralatan;
use App\Asuransi;
use App\Layanan;
use App\Peralatan;

class Faskes extends Model
{
	protected $table = 'faskes';
	protected $fillable = ['id','nama_tempat','alamat','deskripsi','telepon','jam_buka','jam_tutup','hari_buka','hari_tutup','latitude','longitude','hapus','users_id'];

	public function getAllFaskes()
	{
		return $this->where('hapus', 0)->get();
	}

	public function getAllFaskesbyID($id)
	{
		return $this->where('id', $id)->get();
	}

	public function getLastId()
	{
		return $this->orderBy('id', 'desc')->first();
	}

	public function getTotalFaskesBelumAktif()
	{
		return $this->where('hapus', 1)->count();
	}

	public function getTotalAktifFaskes()
	{
		return $this->where('hapus', 0)->count();
	}


	/* -- Global Start --*/
	public function getCoordinate($alamat)
	{
		$address = urlencode($alamat);
		$api = "KEY";
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false&key=$api";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_PROXYPORT, 3128);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($curl);
		curl_close($curl);
		$data_address = json_decode($response);

		$lat = $data_address->results[0]->geometry->location->lat;
		$long = $data_address->results[0]->geometry->location->lng;       

		$arrayLatLong = array($long, $lat);
		if ($lat >= -7.342530 && $lat <= -7.194900 && $long <= 112.842469 && $long >= 112.578294) {
			return $arrayLatLong;
		}
		else {
			return "Lokasi tidak dalam wilayah Surabaya";
		}
	}

	/* Rumus Cosine */
	public function cosine(array $vec1, array $vec2)
	{
		return $this->_dotProduct($vec1, $vec2) / ($this->_absVector($vec1) * $this->_absVector($vec2));
	}

	protected function _dotProduct(array $vec1, array $vec2)
	{
		$result = 0;		
		foreach (array_keys($vec1) as $key1) {
			foreach (array_keys($vec2) as $key2) {
				if ($key1 === $key2) $result += $vec1[$key1] * $vec2[$key2];
			}
		}
		return $result;
	}

	protected function _absVector(array $vec)
	{
		$result = 0;
		foreach (array_values($vec) as $value) {
			$result += $value * $value;
		}
		return sqrt($result);
	}

	/* Rumus Jaccard */
	public function jaccard(array $vec1, array $vec2)
	{
		return $this->_jDotProduct($vec1, $vec2) / ($this->_jAbsVector($vec1) + $this->_jAbsVector($vec2) - $this->_jDotProduct($vec1, $vec2));
	}

	protected function _jDotProduct(array $vec1, array $vec2)
	{
		$result = 0;		
		foreach (array_keys($vec1) as $key1) {
			foreach (array_keys($vec2) as $key2) {
				if ($key1 === $key2) $result += $vec1[$key1] * $vec2[$key2];
			}
		}
		return $result;
	}

	protected function _jAbsVector(array $vec)
	{
		$result = 0;
		foreach (array_values($vec) as $value) {
			$result += $value * $value;
		}
		return $result;
	}

	/* Rumus Manhattan */
	public function manhattan($vector1, $vector2)
	{
		$n = count($vector1);
		$sum = 0;
		foreach ($vector1 as $key => $value) {
			$sum += abs($vector1[$key] - $vector2[$key]);
		}
		return $sum;
	}

	/* Rumus Euclidean */
	public function euclidean($vector1, $vector2)
	{
		$n = count($vector1);
		$sum = 0;
		foreach ($vector1 as $key => $value) {
			$sum += ($vector1[$key] - $vector2[$key]) * ($vector1[$key] - $vector2[$key]);
		}
		return sqrt($sum);
	}

	public function getFaskesAllInOne($keyword, $layanan, $asuransi, $peralatan, $jambuka, $jamtutup, $haribuka, $haritutup)
	{
		$end_result = array();
		$v1 = array();
		$v2 = array();  
		$hasil = array();
		$hasilSearch = array();
		$hasilSearchID = array();
		$hasilSort = array();

		$query = Faskes::all();

		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		$tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();

		$tokens = $tokenizer->tokenize( $stemmer->stem($keyword) );
		$count = array_count_values($tokens);

		foreach (array_unique($tokens) as $key => $value) {
			$v1[$value] = $count[$value];
		}        

		foreach ($query as $row) {
			foreach ($v1 as $key => $values) {
				$query2 = Pencarian_TFIDF::where('kata', $key)->where('faskes_id', $row->id)->get();
				$v2[$key] = 0;
				foreach ($query2 as $row2) {
					$v2[$key] = $row2->jumlah;
				}
			}

			$temp = array();
			$temp[] = $row->nama_tempat;
			$temp[] = $row->alamat;
			$temp[] = Str::limit($row->deskripsi, 225);
			if (empty(array_filter($v2))) {
				$temp[] = 0;
			}
			else {
				$temp[] = $this->cosine($v1, $v2);
			}
			$temp[] = $row->id;
			$temp[] = $row->hapus;
			$hasilSearch[] = $temp;
			unset($temp);
		}

		foreach ($hasilSearch as $key => $row) {
			$hasilSort[$key] = $row[3];
		}

		array_multisort($hasilSort, SORT_DESC, $hasilSearch);

		foreach ($hasilSearch as $key => $row) {
			$hasilSearchID[] = $row[4];
		}

		/* Pengecekan Form */
		$faskes = $this->whereIn('id', $hasilSearchID);
		if (!empty($jambuka)) {
			$faskes = $faskes->where('jam_buka', '>=', "'" . $jambuka . "'");
		}
		if (!empty($jamtutup)) {
			$faskes = $faskes->where('jam_tutup', '<=', "'" . $jamtutup . "'");
		}
		if (!empty($haribuka)) {
			$faskes = $faskes->where('hari_buka', "'" . $haribuka . "'");
		}
		if (!empty($haritutup)) {
			$faskes = $faskes->where('hari_tutup', "'" . $haritutup . "'");
		}
		$hasil = $faskes->get();

		/* Pencarian Layanan */
		if (!empty($layanan)) {
			$m_layanan = Layanan::where('id', $layanan)->first();
			$faskes_layanan = Faskes_Layanan::where('layanan_id', $m_layanan->id)->get();
			foreach ($hasil as $data) {
				foreach ($faskes_layanan as $data2) {
					if ($data->id == $data2->faskes_id) {
						$end_result[] = $data->id;
						break;
					}
				}
			}
		}

		/* Pencarian Asuransi */
		if (!empty($asuransi)) {
			$m_asuransi = Asuransi::where('id', $asuransi)->first();
			$faskes_asuransi = Faskes_Asuransi::where('asuransi_id', $m_asuransi->id)->get();
			$temp = array();
			if (empty($end_result)) {
				foreach ($hasil as $data) {
					$temp[] = $data->id;
				}
			} else {
				for ($i = 0; $i < count($end_result); $i++) {
					$temp[] = $end_result[$i];	
				}
			}

			$end_result = array();
			for ($j = 0; $j < count($temp); $j++) {
				foreach ($faskes_asuransi as $data2) {
					if ($temp[$j] == $data2->faskes_id) {
						$end_result[] = $temp[$j];
						break;
					}
				}
			}
		}

		/* Pencarian Peralatan */
		if (!empty($peralatan)) {
			$m_peralatan = Peralatan::where('id', $peralatan)->first();
			$faskes_peralatan = Faskes_Peralatan::where('peralatan_id', $m_peralatan->id)->get();
			$temp = array();
			if (empty($end_result)) {
				foreach ($hasil as $data) {
					$temp[] = $data->id;
				}
			} else {
				for ($i = 0; $i < count($end_result); $i++) {
					$temp[] = $end_result[$i];	
				}
			}

			$end_result = array();
			for ($j = 0; $j < count($temp); $j++) {
				foreach ($faskes_peralatan as $data2) {
					if ($temp[$j] == $data2->faskes_id) {
						$end_result[] = $temp[$j];
						break;
					}
				}
			}
		}

		/* Pencarian NULL */
		if (empty($end_result)) {
			foreach($hasil as $data) {
				$end_result[] = $data->id;
			}
		}

		/* End result */
		$end_result2 = array();
		foreach ($hasilSearch as $key => $row) {
			foreach ($end_result as $key2 => $row2) {
				if($row[4] == $row2)
				{
					$temp2 = array();
					$temp2[] = $row[0];
					$temp2[] = $row[1];
					$temp2[] = $row[2];
					$temp2[] = $row[3];
					$temp2[] = $row[4];
					$temp2[] = $row[5];
					$end_result2[] = $temp2;
					unset($temp2);
					break;
				}
			}
		}
		return $end_result2;
	}
	/* -- Global End --*/


	/* -- Public Start --*/
	public function insertFaskes($namatempat, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longitude, $latitude)
	{
		$insertFaskes = new Faskes(array(
			'nama_tempat'	=> $namatempat,
			'alamat' 		=> $alamat,
			'deskripsi' 	=> $deskripsi,
			'telepon' 		=> $telepon,
			'jam_buka' 		=> $jambuka,
			'jam_tutup' 	=> $jamtutup,
			'hari_buka' 	=> $haribuka,
			'hari_tutup' 	=> $haritutup,
			'longitude' 	=> $longitude,
			'latitude' 		=> $latitude,
			'hapus' 		=> 1,
			'users_id' 		=> 2,
		));
		$insertFaskes->save();
	}
	/* -- Public End --*/


	/* -- Admin dan Super Admin Start --*/
	public function a_insertFaskes($namatempat, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longitude, $latitude, $userid)
	{
		$insertFaskes = new Faskes(array(
			'nama_tempat'	=> $namatempat,
			'alamat' 		=> $alamat,
			'deskripsi' 	=> $deskripsi,
			'telepon' 		=> $telepon,
			'jam_buka' 		=> $jambuka,
			'jam_tutup' 	=> $jamtutup,
			'hari_buka' 	=> $haribuka,
			'hari_tutup' 	=> $haritutup,
			'longitude' 	=> $longitude,
			'latitude' 		=> $latitude,
			'hapus' 		=> 1,
			'users_id' 		=> $userid,
		));
		$insertFaskes->save();
	}

	public function a_updateFaskes($id, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longitude, $latitude)
	{
		$data = $this->where('id', $id)->first();

		$data->alamat 		= $alamat;
		$data->deskripsi 	= $deskripsi;
		$data->telepon 		= $telepon;
		$data->jam_buka 	= $jambuka;
		$data->jam_tutup	= $jamtutup;
		$data->hari_buka 	= $haribuka;
		$data->hari_tutup	= $haritutup;
		$data->longitude	= $longitude;
		$data->latitude		= $latitude;
		$data->save();
	}

	public function a_updateMap($id, $longitude, $latitude)
	{
		$data = $this->where('id', $id)->first();

		$data->longitude = $longitude;
		$data->latitude	 = $latitude;
		$data->save();
	}

	public function a_statusFaskes($status, $id)
	{
		$data = $this->where('id', $id)->first();
		$data->hapus = $status;
		$data->save();
	}
	/* -- Admin dan Super Admin End --*/


	/* -- Super Admin Start --*/
	public function a_insertFaskesSuper($namatempat, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longitude, $latitude, $userid)
	{
		$insertFaskes = new Faskes(array(
			'nama_tempat'	=> $namatempat,
			'alamat' 		=> $alamat,
			'deskripsi' 	=> $deskripsi,
			'telepon' 		=> $telepon,
			'jam_buka' 		=> $jambuka,
			'jam_tutup' 	=> $jamtutup,
			'hari_buka' 	=> $haribuka,
			'hari_tutup' 	=> $haritutup,
			'longitude' 	=> $longitude,
			'latitude' 		=> $latitude,
			'hapus' 		=> 1,
			'users_id' 		=> $userid,
		));
		$insertFaskes->save();
	}
	/* -- Super Admin End --*/
}