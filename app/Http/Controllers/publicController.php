<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Faskes;
use App\Faskes_Layanan;
use App\Layanan;
use App\Faskes_Asuransi;
use App\Asuransi;
use App\Faskes_Peralatan;
use App\Peralatan;
use App\Faskes_Penyakit_Dokter;
use App\Dokter;
use App\Penyakit;
use App\Ulasan;
use App\Pencarian_TFIDF;
use DB;

class publicController extends Controller
{
    public function index()
    {
        $faskes = Faskes::all();
        return view ('app_public.submit');
    }

    public function indexPublic()
    {
        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $layanan_data = new Layanan();
        $layanan = $layanan_data->getAllLayanan();

        $asuransi_data = new Asuransi();
        $asuransi = $asuransi_data->getAllAsuransi();

        $peralatan_data = new Peralatan();
        $peralatan = $peralatan_data->getAllPeralatan();

        return view ('index', compact('faskes', 'layanan', 'asuransi', 'peralatan'));
    }

    public function insertFaskes(Request $request)
    {
        $faskes_data = new Faskes();

        $namatempat = $request->get('m_namatempat');
        $alamat     = $request->get('m_alamat');
        $deskripsi  = $request->get('m_deskripsi');
        $telepon    = $request->get('m_telepon');
        $jambuka    = $request->get('m_jambuka');
        $jamtutup   = $request->get('m_jamtutup');
        $haribuka   = $request->get('m_haribuka');
        $haritutup  = $request->get('m_haritutup');
        $longlat    = $faskes_data->getCoordinate($alamat);

        if ($longlat == "Lokasi tidak dalam wilayah Surabaya") {
            $request->session()->flash('gagal', "Maaf, Lokasi pelayanan kesehatan tidak dalam wilayah Surabaya.");
            return redirect('/');
        }
        else {
            $faskes_data->insertFaskes($namatempat, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longlat[0], $longlat[1]);
            $request->session()->flash('sukses', "Terimakasih, lokasi pelayanan kesehatan telah ditambahkan.");
            return redirect('/');
        }
    }

    public function search(Request $request)
    {
        $v1 = array();
        $v2 = array();  
        $hasil = array();
        $hasilSort = array();

        $faskes_data = new Faskes();
        $query = Faskes::all();

        $kalimat = $request->get('m_keyword');

        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();
        $tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer = $tokenizerFactory->createDefaultTokenizer();

        $tokens = $tokenizer->tokenize( $stemmer->stem($kalimat) );
        $count = array_count_values($tokens);

        foreach (array_unique($tokens) as $key => $value) {
            $v1[$value] = $count[$value];
        }        
        
        foreach ($query as $row) {
            foreach ($v1 as $key => $values) {
                $query2 = Pencarian_TFIDF::where('kata', $key)->where('faskes_id', $row->id)->offset(0)->limit(8)->get();
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
                $temp[] = $faskes_data->cosine($v1, $v2);
            }
            $temp[] = $row->id;
            $temp[] = $row->hapus;
            $hasil[] = $temp;
            unset($temp);
        }

        foreach ($hasil as $key => $row) {
            $hasilSort[$key] = $row[3];
        }

        array_multisort($hasilSort, SORT_DESC, $hasil);
        return view ('app_public.search', compact('hasil', $hasil));
    }

    public function searchAdvanced(Request $request)
    {
        $faskes_data = new Faskes();
        $keyword    = $request->get('m_keyword');
        $layanan    = $request->get('m_layanan');
        $asuransi   = $request->get('m_asuransi');
        $peralatan  = $request->get('m_peralatan');
        $jambuka    = $request->get('m_jambuka');
        $jamtutup   = $request->get('m_jamtutup');
        $haribuka   = $request->get('m_haribuka');
        $haritutup  = $request->get('m_haritutup');

        $faskes = $faskes_data->getFaskesAllInOne($keyword, $layanan, $asuransi, $peralatan, $jambuka, $jamtutup, $haribuka, $haritutup);
        
        $hasil = null;
        if (!empty($faskes)) {
            $hasil = $faskes;
        }
        return view ('app_public.search', compact('hasil', $hasil));
    }

    public function searchDetail(Request $request)
    {
        $faskes_data = new Faskes();
        $faskes_layanan_data = new Faskes_Layanan();
        $layanan_data = new Layanan();
        $faskes_asuransi_data = new Faskes_Asuransi();
        $asuransi_data = new Asuransi();
        $faskes_peralatan_data = new Faskes_Peralatan();
        $peralatan_data = new Peralatan();
        $faskes_penyakit_dokter_data = new Faskes_Penyakit_Dokter();
        $dokter_data = new Dokter();
        $penyakit_data = new Penyakit();
        $ulasan_data = new Ulasan();

        $search_id = $request->get('m_searchid');

        $data_search = $faskes_data->getAllFaskesbyID($search_id);

        $layanan_search = $faskes_layanan_data->getAllbyIDFaskes($search_id);
        $layanan = $layanan_data->getAllLayanan();

        $asuransi_search = $faskes_asuransi_data->getAllbyIDFaskes($search_id);
        $asuransi = $asuransi_data->getAllAsuransi();

        $peralatan_search = $faskes_peralatan_data->getAllbyIDFaskes($search_id);
        $peralatan = $peralatan_data->getAllPeralatan();

        $dokter_search = $faskes_penyakit_dokter_data->getAllbyIDFaskes($search_id);
        $dokter = $dokter_data->getAllDokter();
        $penyakit = $penyakit_data->getAllPenyakit();

        $ulasan_search = $ulasan_data->getAllUlasan($search_id);

        return view ('app_public.search_detail', compact('data_search', 'layanan_search', 'layanan', 'asuransi_search', 'asuransi', 'peralatan_search', 'peralatan', 'dokter_search', 'dokter', 'penyakit', 'ulasan_search'));
    }

    public function insertUlasan(Request $request)
    {
        $ulasan_data = new Ulasan();

        $id             = $request->get('m_idnamatempat');
        $nama_pengguna  = $request->get('m_namapengguna');
        $ulasan         = $request->get('m_ulasan');
        $rating_faskes  = $request->get('m_ratingfaskes');
        $rating_layanan = $request->get('m_ratinglayanan');

        if($ulasan == null) {
            $request->session()->flash('gagal', "Maaf, ulasan tidak boleh kosong.");
            return redirect('/');
        }
        else {
            $ulasan_data->insertUlasan($id, $nama_pengguna, $ulasan, $rating_faskes, $rating_layanan);
            $request->session()->flash('sukses', "Terimakasih, ulasan sedang diverifikasi oleh Admin.");
            return redirect('/');
        }
    }
}