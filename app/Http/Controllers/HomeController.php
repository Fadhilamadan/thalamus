<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Faskes;
use App\Faskes_Layanan;
use App\Layanan;
use App\Faskes_Asuransi;
use App\Asuransi;
use App\Faskes_Penyakit_Dokter;
use App\Dokter;
use App\Faskes_Peralatan;
use App\Peralatan;
use App\Penyakit;
use App\Ulasan;
use App\Pencarian_TFIDF;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* Global */
    public function makeToTFIDF($kalimat_bersih, $option, $id)
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer = $tokenizerFactory->createDefaultTokenizer();

        $tfidf_data = new Pencarian_TFIDF();

        $temp_tokenize = array();
        $kalimat = array();
        $arrayKata = array();
        $arrayTabelData = array();
        $dft = array();
        $idf = array();
        $tfidf = array();

        if ($option == 0) {
            $faskes_query = Faskes::where('hapus', 0)->get();
        } else {
            $faskes_query = Faskes::where('id', '<>', $id)->where('hapus', 0)->get();
        }

        $tokens = $tokenizer->tokenize( $stemmer->stem($kalimat_bersih) );
        foreach ($tokens as $key => $value) {
            if(empty($temp_tokenize)) {
                $temp_tokenize[] = $value;
                $tfidf_data->a_insertTFIDF($id, $value, 0);
            }
            else {
                if(!(in_array($value, $temp_tokenize))) {
                    $temp_tokenize[] = $value;
                    $tfidf_data->a_insertTFIDF($id, $value, 0);
                }
            }
        }

        foreach ($faskes_query as $row) {
            $kalimat[$row->id] = $row->nama_tempat . " " . $row->alamat . " " . $row->deskripsi;
        }

        /* TF-Raw */
        foreach ($kalimat as $key => $value) {
            $tokens = $tokenizer->tokenize( $stemmer->stem($value) );
            foreach ($tokens as $key => $value2) {
                if (isset($arrayKata[$value2])) {
                    $arrayKata[$value2] ++;
                } else {
                    $arrayKata[$value2] = 1;
                }
            }
        }

        /* Sort */
        ksort($arrayKata);

        /* TF-Raw detail per Dokumen */
        foreach ($arrayKata as $key => $value) {
            $arrayTabelData[$key] = array();
            foreach ($kalimat as $key2 => $value2) {
                $arrayTabelData[$key][$key2] = 0;
                $tokens = $tokenizer->tokenize( $stemmer->stem($value2) );
                foreach ($tokens as $key3 => $value3) {
                    if ($key == $value3) {
                        $arrayTabelData[$key][$key2]++;
                    }
                }
            }
        }

        /* DFt + IDF */
        foreach ($arrayKata as $key => $value) {
            $dft[$key] = 0;
            foreach ($kalimat as $key2 => $value2) {
                if($arrayTabelData[$key][$key2] > 0)
                    $dft[$key]++;
            }
            $idf[$key] = log10(count($arrayTabelData[$key])/$dft[$key]);
        }

        /* TF-IDF + Update Jumlah */
        foreach ($arrayKata as $key => $value) {
            $tfidf[$key] = array();
            foreach ($kalimat as $key2 => $value2) {
                $tfidf[$key][$key2] = $arrayTabelData[$key][$key2] * $idf[$key];
                $tfidf_data->a_updateTFIDF($key2, $key, $tfidf[$key][$key2]);
            }
        }
    }

    public function makeToTFIDFupdate($kalimat_bersih, $option, $id)
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer = $tokenizerFactory->createDefaultTokenizer();

        $tfidf_data = new Pencarian_TFIDF();

        $temp_tokenize = array();
        $kalimat = array();
        $arrayKata = array();
        $arrayTabelData = array();
        $dft = array();
        $idf = array();
        $tfidf = array();

        if ($option == 0) {
            $faskes_query = Faskes::where('hapus', 0)->get();
        } else {
            $faskes_query = Faskes::where('id', '<>', $id)->where('hapus', 0)->get();
        }

        foreach ($faskes_query as $row) {
            $kalimat[$row->id] = $row->nama_tempat . " " . $row->alamat . " " . $row->deskripsi;
        }

        /* TF-Raw */
        foreach ($kalimat as $key => $value) {
            $tokens = $tokenizer->tokenize( $stemmer->stem($value) );
            foreach ($tokens as $key => $value2) {
                if (isset($arrayKata[$value2])) {
                    $arrayKata[$value2] ++;
                } else {
                    $arrayKata[$value2] = 1;
                }
            }
        }

        /* Sort */
        ksort($arrayKata);

        /* TF-Raw detail per Dokumen */
        foreach ($arrayKata as $key => $value) {
            $arrayTabelData[$key] = array();
            foreach ($kalimat as $key2 => $value2) {
                $arrayTabelData[$key][$key2] = 0;
                $tokens = $tokenizer->tokenize( $stemmer->stem($value2) );
                foreach ($tokens as $key3 => $value3) {
                    if ($key == $value3) {
                        $arrayTabelData[$key][$key2]++;
                    }
                }
            }
        }

        /* DFt + IDF */
        foreach ($arrayKata as $key => $value) {
            $dft[$key] = 0;
            foreach ($kalimat as $key2 => $value2) {
                if($arrayTabelData[$key][$key2] > 0)
                    $dft[$key]++;
            }
            $idf[$key] = log10(count($arrayTabelData[$key])/$dft[$key]);
        }

        /* TF-IDF + Update Jumlah */
        foreach ($arrayKata as $key => $value) {
            $tfidf[$key] = array();
            foreach ($kalimat as $key2 => $value2) {
                $tfidf[$key][$key2] = $arrayTabelData[$key][$key2] * $idf[$key];
                $tfidf_data->a_updateTFIDF($key2, $key, $tfidf[$key][$key2]);
            }
        }
    }
    /* Global */


    /* Beranda */
    public function beranda()
    {
        $users_data = new User();
        $totalOwner = $users_data->getTotalOwner();

        $faskes_data            = new Faskes();
        $faskes                 = $faskes_data->getAllFaskes();
        $totalFaskesBelumAktif  = $faskes_data->getTotalFaskesBelumAktif();
        $totalAktifFaskes       = $faskes_data->getTotalAktifFaskes();

        $dokter_data = new Dokter();
        $totalDokter = $dokter_data->getTotalDokter();

        return view('app_admin/beranda', compact('totalOwner', 'faskes', 'totalFaskesBelumAktif', 'totalAktifFaskes', 'totalDokter'));
    }
    /* Beranda */


    /*
     *
     *  Admin
     * 
     */

    /* Pelayan Kesehatan */
    public function kesehatanDaftar()
    {
        $allDataFaskes = Faskes::all();
        return view('app_admin/kesehatan_daftar', compact('allDataFaskes'));
    }

    public function kesehatanTambah()
    {
        return view('app_admin/kesehatan_tambah');
    }

    public function kesehatanMaps(Request $request)
    {
        $faskes_data = new Faskes();

        $map_id = $request->get('m_idmap');

        $data_map = $faskes_data->getAllFaskesbyID($map_id);
        return view ('app_admin/kesehatan_maps', compact('data_map'));
    }

    public function insertFasKes(Request $request)
    {
        $faskes_data = new Faskes();

        $userid     = $request->get('m_userid');
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
            return redirect('/kesehatan_tambah');
        }
        else {
            $faskes_data->a_insertFaskes($namatempat, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longlat[0], $longlat[1], $userid);
            $request->session()->flash('sukses', "Terimakasih, lokasi pelayanan kesehatan telah ditambahkan.");
            return redirect('/kesehatan_tambah');
        }
    }

    public function updateFaskes(Request $request)
    {
        $faskes_data = new Faskes();
        
        $id         = $request->get('m_idnamatempat');
        $alamat     = $request->get('m_alamat');
        $deskripsi  = $request->get('m_deskripsi');
        $telepon    = $request->get('m_telepon');
        $jambuka    = $request->get('m_jambuka');
        $jamtutup   = $request->get('m_jamtutup');
        $haribuka   = $request->get('m_haribuka');
        $haritutup  = $request->get('m_haritutup');
        $longlat    = $faskes_data->getCoordinate($alamat);
        $status     = $request->get('m_status');

        if ($longlat == "Lokasi tidak dalam wilayah Surabaya") {
            $request->session()->flash('gagal', "Maaf, data pelayanan kesehatan tidak dalam wilayah Surabaya.");
            return redirect('/kesehatan_daftar');
        }
        else {
            $faskes_data->a_updateFaskes($id, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longlat[0], $longlat[1]);
            $faskes_data->a_statusFaskes($status, $id);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = "";
            if ($status != 0) {
                $faskes_query = $faskes_data->getAllFaskesbyID($id);
                foreach($faskes_query as $faskes_getData) {
                    $kalimat_bersih = $faskes_getData->nama_tempat . " " . $faskes_getData->alamat . " " . $faskes_getData->deskripsi;
                }
                $tfidf_data->a_deleteTFIDF($id);
                $this->makeToTFIDFupdate($kalimat_bersih, 0, $id);
            }

            $request->session()->flash('sukses', "Terimakasih, data pelayanan kesehatan telah diperbarui.");
            return redirect('/kesehatan_daftar');
        }
    }

    public function updateMap(Request $request)
    {
        $faskes_data = new Faskes();
        
        $id        = $request->get('m_idnamatempat');
        $latitude  = $request->get('m_latitude');
        $longitude = $request->get('m_longitude');

        if ($latitude == null || $longitude == null) {
            $request->session()->flash('gagal', "Maaf, lokasi Google Maps tidak berhasil diperbarui.");
            return redirect('/kesehatan_daftar');
        }
        else {
            $faskes_data->a_updateMap($id, $longitude, $latitude);
            $request->session()->flash('sukses', "Terimakasih, lokasi Google Maps telah berhasil diperbarui.");
            return redirect('/kesehatan_daftar');
        }
    }

    public function statusFaskes(Request $request)
    {
        $faskes_data = new Faskes;

        $id     = $request->get('m_idnamatempat');
        $status = $request->get('m_status');

        if(empty($faskes_data)) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/kesehatan_daftar');
        }
        else {
            $faskes_data->a_statusFaskes($status, $id);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = "";
            if ($status == 0) {
                $faskes_query = $faskes_data->getAllFaskesbyID($id);
                foreach($faskes_query as $faskes_getData) {
                    $kalimat_bersih = $faskes_getData->nama_tempat . " " . $faskes_getData->alamat . " " . $faskes_getData->deskripsi;
                }
                $this->makeToTFIDF($kalimat_bersih, 0, $id);
            }
            else {
                $tfidf_data->a_deleteTFIDF($id);
                $this->makeToTFIDF($kalimat_bersih, 1, $id);
            }

            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/kesehatan_daftar');
        }
    }
    /* Pelayan Kesehatan */


    /* Layanan */
    public function layananDaftar()
    {
        $allDataFaskesLayanan = Faskes_Layanan::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $layanan_data = new Layanan();
        $layanan = $layanan_data->getAllLayanan();

        return view('app_admin/layanan_daftar', compact('allDataFaskesLayanan', 'faskes', 'layanan'));
    }

    public function layananTambah()
    {
        $allDataFaskesLayanan = Faskes_Layanan::all();
        
        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $layanan_data = new Layanan();
        $layanan = $layanan_data->getAllLayanan();

        return view('app_admin/layanan_tambah', compact('allDataFaskesLayanan', 'faskes', 'layanan'));
    }

    public function insertLayanan(Request $request)
    {
        $layanan_data = new Layanan;
        $faskes_layanan_data = new Faskes_Layanan();

        $faskes  = $request->get('m_namatempat');
        $layanan = $request->get('m_layanan');

        if($faskes == null || $layanan == null) {
            $request->session()->flash('gagal', "Maaf, layanan tidak boleh kosong.");
            return redirect('/layanan_tambah');
        }
        else {
            $faskes_layanan_data->a_deleteLayanan($faskes);
            $faskes_layanan_data->a_insertLayanan($faskes, $layanan);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = array();
            $fitur_query = $layanan_data->getAllLayananbyIDFitur($layanan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_layanan;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, layanan telah ditambahkan.");
            return redirect('/layanan_tambah');
        }
    }

    public function updateLayanan(Request $request)
    {
        $layanan_data = new Layanan;
        $faskes_layanan_data = new Faskes_Layanan();

        $faskes  = $request->get('m_idnamatempat');
        $layanan = $request->get('m_layanan');

        if($layanan == null) {
            $request->session()->flash('gagal', "Maaf, layanan tidak boleh kosong.");
            return redirect('/layanan_daftar');
        }
        else {
            $tfidf_data = new Pencarian_TFIDF();
            $this->makeToTFIDFupdateFitur($faskes, 0, $tfidf_data);

            $faskes_layanan_data->a_deleteLayanan($faskes);
            $faskes_layanan_data->a_insertLayanan($faskes, $layanan);

            $kalimat_bersih = array();
            $fitur_query = $layanan_data->getAllLayananbyIDFitur($layanan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_layanan;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, layanan telah diperbarui.");
            return redirect('/layanan_daftar');
        }
    }

    public function tambahNamaLayanan(Request $request)
    {
        $layanan_data = new Layanan();

        $namaLayanan = $request->get('m_namalayanan');

        if($namaLayanan == null) {
            $request->session()->flash('gagal', "Maaf, nama layanan tidak boleh kosong.");
            return redirect('/layanan_tambah');
        }
        else {
            $layanan_data->a_tambahNamaLayanan($namaLayanan);
            $request->session()->flash('sukses', "Terimakasih, nama layanan telah ditambahkan.");
            return redirect('/layanan_tambah');
        }
    }
    /* Layanan */


    /* Asuransi */
    public function asuransiDaftar()
    {
        $allDataAsuransi = Faskes_Asuransi::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $asuransi_data = new Asuransi();
        $asuransi = $asuransi_data->getAllAsuransi();

        return view('app_admin/asuransi_daftar', compact('allDataAsuransi', 'faskes', 'asuransi'));
    }

    public function asuransiTambah()
    {
        $allDataAsuransi = Faskes_Asuransi::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $asuransi_data = new Asuransi();
        $asuransi = $asuransi_data->getAllAsuransi();

        return view('app_admin/asuransi_tambah', compact('allDataAsuransi', 'faskes', 'asuransi'));
    }

    public function insertAsuransi(Request $request)
    {
        $asuransi_data = new Asuransi;
        $faskes_asuransi_data = new Faskes_Asuransi();

        $faskes   = $request->get('m_namatempat');
        $asuransi = $request->get('m_asuransi');

        if($faskes == null || $asuransi == null) {
            $request->session()->flash('gagal', "Maaf, asuransi tidak boleh kosong.");
            return redirect('/asuransi_tambah');
        }
        else {
            $faskes_asuransi_data->a_deleteAsuransi($faskes);
            $faskes_asuransi_data->a_insertAsuransi($faskes, $asuransi);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = array();
            $fitur_query = $asuransi_data->getAllAsuransibyIDFitur($asuransi);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_asuransi;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, asuransi telah ditambahkan.");
            return redirect('/asuransi_tambah');
        }
    }

    public function updateAsuransi(Request $request)
    {
        $asuransi_data = new Asuransi;
        $faskes_asuransi_data = new Faskes_Asuransi();

        $faskes   = $request->get('m_idnamatempat');
        $asuransi = $request->get('m_asuransi');

        if($faskes == null || $asuransi == null) {
            $request->session()->flash('gagal', "Maaf, asuransi tidak boleh kosong.");
            return redirect('/asuransi_daftar');
        }
        else {
            $tfidf_data = new Pencarian_TFIDF();
            $this->makeToTFIDFupdateFitur($faskes, 2, $tfidf_data);

            $faskes_asuransi_data->a_deleteAsuransi($faskes);
            $faskes_asuransi_data->a_insertAsuransi($faskes, $asuransi);

            $kalimat_bersih = array();
            $fitur_query = $asuransi_data->getAllAsuransibyIDFitur($asuransi);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_asuransi;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, asuransi telah diperbarui.");
            return redirect('/asuransi_daftar');
        }
    }

    public function tambahNamaAsuransi(Request $request)
    {
        $asuransi_data = new Asuransi();

        $namaAsuransi = $request->get('m_namaasuransi');
        $keterangan   = $request->get('m_keterangan');

        if($namaAsuransi == null || $keterangan == null) {
            $request->session()->flash('gagal', "Maaf, nama asuransi tidak boleh kosong.");
            return redirect('/asuransi_tambah');
        }
        else {
            $asuransi_data->a_tambahNamaAsuransi($namaAsuransi, $keterangan);
            $request->session()->flash('sukses', "Terimakasih, nama asuransi telah ditambahkan.");
            return redirect('/asuransi_tambah');
        }
    }
    /* Asuransi */


    /* Dokter */
    public function dokterDaftar()
    {
        $allDataFaskesPenyakitDokter = Faskes_Penyakit_Dokter::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $penyakit_data = new Penyakit();
        $penyakit = $penyakit_data->getAllPenyakit();

        $dokter_data = new Dokter();
        $dokter = $dokter_data->getAllDokter();

        return view('app_admin/dokter_daftar', compact('allDataFaskesPenyakitDokter', 'faskes', 'penyakit', 'dokter'));
    }

    public function dokterTambah()
    {
        $allDataDokter = Faskes_Penyakit_Dokter::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $penyakit_data = new Penyakit();
        $penyakit = $penyakit_data->getAllPenyakit();

        $dokter_data = new Dokter();
        $dokter = $dokter_data->getAllDokter();

        return view('app_admin/dokter_tambah', compact('allDataDokter', 'faskes', 'penyakit', 'dokter'));
    }

    public function insertDokter(Request $request)
    {
        $faskes_penyakit_dokter_data = new Faskes_Penyakit_Dokter();

        $faskes   = $request->get('m_namatempat');
        $dokter   = $request->get('m_namadokter');
        $penyakit = $request->get('m_penyakit');

        if($faskes == null || $dokter == null || $penyakit == null) {
            $request->session()->flash('gagal', "Maaf, dokter dan penyakit tidak boleh kosong.");
            return redirect('/dokter_tambah');
        }
        else {
            $faskes_penyakit_dokter_data->a_deleteDokter($faskes, $dokter);
            $faskes_penyakit_dokter_data->a_insertDokter($faskes, $penyakit, $dokter);
            $request->session()->flash('sukses', "Terimakasih, dokter dan penyakit telah ditambahkan.");
            return redirect('/dokter_tambah');
        }
    }

    public function updateDokter(Request $request)
    {
        $faskes_penyakit_dokter_data = new Faskes_Penyakit_Dokter();

        $faskes   = $request->get('m_idnamatempat');
        $dokter   = $request->get('m_namadokter');
        $penyakit = $request->get('m_penyakit');

        if($faskes == null || $dokter == null || $penyakit == null) {
            $request->session()->flash('gagal', "Maaf, dokter dan penyakit tidak boleh kosong.");
            return redirect('/dokter_daftar');
        }
        else {
            $faskes_penyakit_dokter_data->a_deleteDokter($faskes, $dokter);
            $faskes_penyakit_dokter_data->a_insertDokter($faskes, $penyakit, $dokter);
            $request->session()->flash('sukses', "Terimakasih, dokter dan penyakit telah diperbarui.");
            return redirect('/dokter_daftar');
        }
    }

    public function tambahNamaDokter(Request $request)
    {
        $dokter_data = new Dokter();

        $namaTempat = $request->get('n_namatempat');
        $namaDokter = $request->get('n_namadokter');

        if($namaTempat == null || $namaDokter == null) {
            $request->session()->flash('gagal', "Maaf, nama dokter tidak boleh kosong.");
            return redirect('/dokter_tambah');
        }
        else {
            $dokter_data->a_tambahNamaDokter($namaTempat, $namaDokter);
            $request->session()->flash('sukses', "Terimakasih, nama dokter telah ditambahkan.");
            return redirect('/dokter_tambah');
        }
    }

    public function dataDokter(Request $request)
    {
        $dokter_data = Dokter::select('id', 'nama_dokter')->where('faskes_id', $request->id)->get();
        return response()->json($dokter_data);
    }
    /* Dokter */


    /* Penyakit */
    public function tambahNamaPenyakit(Request $request)
    {
        $penyakit_data = new Penyakit();

        $namaPenyakit = $request->get('m_namapenyakit');

        if($namaPenyakit == null) {
            $request->session()->flash('gagal', "Maaf, nama penyakit tidak boleh kosong.");
            return redirect('/dokter_tambah');
        }
        else {
            $penyakit_data->a_tambahNamaPenyakit($namaPenyakit);
            $request->session()->flash('sukses', "Terimakasih, nama penyakit telah ditambahkan.");
            return redirect('/dokter_tambah');
        }
    }

    public function dataPenyakit(Request $request)
    {
        $penyakit_data = Penyakit::all();
        $faskes_penyakit_dokter_data = DB::table('faskes_has_penyakit_has_dokter')
                                        ->join('penyakit', 'faskes_has_penyakit_has_dokter.penyakit_id', '=', 'penyakit.id')
                                        ->select('faskes_has_penyakit_has_dokter.penyakit_id', 'penyakit.nama_penyakit')
                                        ->where('dokter_id', $request->id)
                                        ->get();
        return response()->json(array('0' => $faskes_penyakit_dokter_data, '1' => $penyakit_data));
    }
    /* Penyakit */


    /* Peralatan */
    public function peralatanDaftar()
    {
        $allDataPeralatan = Faskes_Peralatan::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $peralatan_data = new Peralatan();
        $peralatan = $peralatan_data->getAllPeralatan();

        return view('app_admin/peralatan_daftar', compact('allDataPeralatan', 'faskes', 'peralatan'));
    }

    public function peralatanTambah()
    {
        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $peralatan_data = new Peralatan();
        $peralatan = $peralatan_data->getAllPeralatan();

        return view('app_admin/peralatan_tambah', compact('faskes', 'peralatan'));
    }

    public function insertPeralatan(Request $request)
    {
        $peralatan_data = new Peralatan();
        $faskes_peralatan_data = new Faskes_Peralatan();

        $faskes     = $request->get('m_namatempat');
        $peralatan  = $request->get('m_peralatan');
        $keterangan = $request->get('m_keterangan');

        if($peralatan == null) {
            $request->session()->flash('gagal', "Maaf, peralatan tidak boleh kosong.");
            return redirect('/peralatan_tambah');
        }
        else {
            $faskes_peralatan_data->a_deletePeralatan($faskes, $peralatan);
            $faskes_peralatan_data->a_insertPeralatan($faskes, $peralatan, $keterangan);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = "";
            $fitur_query = $peralatan_data->getAllPeralatanbyID($peralatan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih = $fitur_getData->nama_peralatan;
            }
            $this->makeToTFIDFfitur($kalimat_bersih, 0, $faskes);

            $request->session()->flash('sukses', "Terimakasih, peralatan telah ditambahkan.");
            return redirect('/peralatan_tambah');
        }
    }

    public function updatePeralatan(Request $request)
    {
        $peralatan_data = new Peralatan();
        $faskes_peralatan_data = new Faskes_Peralatan();

        $faskes     = $request->get('m_idnamatempat');
        $peralatan  = $request->get('m_peralatan');
        $keterangan = $request->get('m_keterangan');

        if($peralatan == null) {
            $request->session()->flash('gagal', "Maaf, peralatan tidak boleh kosong.");
            return redirect('/peralatan_daftar');
        }
        else {
            $tfidf_data = new Pencarian_TFIDF();
            $this->makeToTFIDFupdateFitur($faskes, 1, $tfidf_data);

            $faskes_peralatan_data->a_deletePeralatan($faskes, $peralatan);
            $faskes_peralatan_data->a_insertPeralatan($faskes, $peralatan, $keterangan);

            $kalimat_bersih = "";
            $fitur_query = $peralatan_data->getAllPeralatanbyID($peralatan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih = $fitur_getData->nama_peralatan;
            }
            $this->makeToTFIDFfitur($kalimat_bersih, 0, $faskes);

            $request->session()->flash('sukses', "Terimakasih, peralatan telah diperbarui.");
            return redirect('/peralatan_daftar');
        }
    }

    public function tambahNamaPeralatan(Request $request)
    {
        $peralatan_data = new Peralatan();

        $namaPeralatan = $request->get('m_namaperalatan');

        if($namaPeralatan == null) {
            $request->session()->flash('gagal', "Maaf, nama peralatan tidak boleh kosong.");
            return redirect('/peralatan_tambah');
        }
        else {
            $peralatan_data->a_tambahNamaPeralatan($namaPeralatan);
            $request->session()->flash('sukses', "Terimakasih, nama peralatan telah ditambahkan.");
            return redirect('/peralatan_tambah');
        }
    }

    public function dataPeralatan(Request $request)
    {
        $faskes_peralatan_data = Faskes_Peralatan::select('keterangan')->where('peralatan_id', $request->id)->get();
        return response()->json($faskes_peralatan_data);
    }
    /* Peralatan */





    /*
     *
     *  Super Admin
     * 
     */

    /* Pelayan Kesehatan */
    public function kesehatanDaftar_super()
    {
        $allDataFaskes = Faskes::all();

        $users_data = new User();
        $users = $users_data->getAllUsers();

        return view('app_superadmin/kesehatan_daftar', compact('allDataFaskes', 'users'));
    }

    public function kesehatanTambah_super()
    {
        return view('app_superadmin/kesehatan_tambah');
    }

    public function kesehatanMaps_super(Request $request)
    {
        $faskes_data = new Faskes();

        $map_id = $request->get('m_idmap');

        $data_map = $faskes_data->getAllFaskesbyID($map_id);
        return view ('app_superadmin/kesehatan_maps', compact('data_map'));
    }

    public function insertFasKes_super(Request $request)
    {
        $faskes_data = new Faskes();

        $userid     = $request->get('m_userid');
        $namatempat = $request->get('m_namatempat');
        $alamat     = $request->get('m_alamat');
        $deskripsi  = $request->get('m_deskripsi');
        $telepon    = $request->get('m_telepon');
        $jambuka    = $request->get('m_jambuka');
        $jamtutup   = $request->get('m_jamtutup');
        $haribuka   = $request->get('m_haribuka');
        $haritutup  = $request->get('m_haritutup');
        $longlat    = $faskes_data->getCoordinate($alamat);
        $status     = $request->get('m_status');

        if ($longlat == "Lokasi tidak dalam wilayah Surabaya") {
            $request->session()->flash('gagal', "Maaf, Lokasi pelayanan kesehatan tidak dalam wilayah Surabaya.");
            return redirect('/kesehatan_daftar_super');
        }
        else {
            $faskes_data->a_insertFaskesSuper($namatempat, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longlat[0], $longlat[1], $userid);
            $request->session()->flash('sukses', "Terimakasih, lokasi pelayanan kesehatan telah ditambahkan.");
            return redirect('/kesehatan_daftar_super');
        }
    }

    public function updateFaskes_super(Request $request)
    {
        $faskes_data = new Faskes();

        $id         = $request->get('m_idnamatempat');
        $alamat     = $request->get('m_alamat');
        $deskripsi  = $request->get('m_deskripsi');
        $telepon    = $request->get('m_telepon');
        $jambuka    = $request->get('m_jambuka');
        $jamtutup   = $request->get('m_jamtutup');
        $haribuka   = $request->get('m_haribuka');
        $haritutup  = $request->get('m_haritutup');
        $longlat    = $faskes_data->getCoordinate($alamat);
        $status     = $request->get('m_status');

        if ($longlat == "Lokasi tidak dalam wilayah Surabaya") {
            $request->session()->flash('gagal', "Maaf, data pelayanan kesehatan tidak dalam wilayah Surabaya.");
            return redirect('/kesehatan_daftar_super');
        }
        else {
            $faskes_data->a_updateFaskes($id, $alamat, $deskripsi, $telepon, $jambuka, $jamtutup, $haribuka, $haritutup, $longlat[0], $longlat[1]);
            $faskes_data->a_statusFaskes($status, $id);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = "";
            $faskes_query = $faskes_data->getAllFaskesbyID($id);
            foreach($faskes_query as $faskes_getData) {
                $kalimat_bersih = $faskes_getData->nama_tempat . " " . $faskes_getData->alamat . " " . $faskes_getData->deskripsi;
            }
            $tfidf_data->a_deleteTFIDF($id);
            $this->makeToTFIDF($kalimat_bersih, 0, $id);

            $request->session()->flash('sukses', "Terimakasih, data pelayanan kesehatan telah diperbarui.");
            return redirect('/kesehatan_daftar_super');
        }
    }

    public function updateMap_super(Request $request)
    {
        $faskes_data = new Faskes();
        
        $id        = $request->get('m_idnamatempat');
        $latitude  = $request->get('m_latitude');
        $longitude = $request->get('m_longitude');

        if ($latitude == null || $longitude == null) {
            $request->session()->flash('gagal', "Maaf, lokasi Google Maps tidak berhasil diperbarui.");
            return redirect('/kesehatan_daftar_super');
        }
        else {
            $faskes_data->a_updateMap($id, $longitude, $latitude);
            $request->session()->flash('sukses', "Terimakasih, lokasi Google Maps telah berhasil diperbarui.");
            return redirect('/kesehatan_daftar_super');
        }
    }

    public function statusFaskes_super(Request $request)
    {
        $faskes_data = new Faskes();

        $id     = $request->get('m_idnamatempat');
        $status = $request->get('m_status');

        if(empty($faskes_data)) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/kesehatan_daftar_super');
        }
        else {
            $faskes_data->a_statusFaskes($status, $id);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = "";
            if ($status == 0) {
                $faskes_query = $faskes_data->getAllFaskesbyID($id);
                foreach($faskes_query as $faskes_getData) {
                    $kalimat_bersih = $faskes_getData->nama_tempat . " " . $faskes_getData->alamat . " " . $faskes_getData->deskripsi;
                }
                $this->makeToTFIDF($kalimat_bersih, 0, $id);
            }
            else {
                $tfidf_data->a_deleteTFIDF($id);
                $this->makeToTFIDF($kalimat_bersih, 1, $id);
            }

            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/kesehatan_daftar_super');
        }
    }
    /* Pelayan Kesehatan */


    /* Layanan */
    public function layananDaftar_super()
    {
        $allDataFaskesLayanan = Faskes_Layanan::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $layanan_data = new Layanan();
        $layanan = $layanan_data->getAllLayanan();

        $users_data = new User();
        $users = $users_data->getAllUsers();

        return view('app_superadmin/layanan_daftar', compact('allDataFaskesLayanan', 'faskes', 'layanan', 'users'));
    }

    public function layananTambah_super()
    {
        $allDataFaskesLayanan = Faskes_Layanan::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $layanan_data = new Layanan();
        $layanan = $layanan_data->getAllLayanan();

        return view('app_superadmin/layanan_tambah', compact('allDataFaskesLayanan', 'faskes', 'layanan'));
    }

    public function layananData_super()
    {
        $layanan_data = Layanan::all();

        return view('app_superadmin/layanan_data', compact('layanan_data'));
    }

    public function insertLayanan_super(Request $request)
    {
        $layanan_data = new Layanan;
        $faskes_layanan_data = new Faskes_Layanan();

        $faskes     = $request->get('m_namatempat');
        $layanan    = $request->get('m_layanan');

        if($faskes == null || $layanan == null) {
            $request->session()->flash('gagal', "Maaf, layanan tidak boleh kosong.");
            return redirect('/layanan_daftar_super');
        }
        else {
            $faskes_layanan_data->a_insertLayanan($faskes, $layanan);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = array();
            $fitur_query = $layanan_data->getAllLayananbyIDFitur($layanan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_layanan;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }
            
            $request->session()->flash('sukses', "Terimakasih, layanan telah ditambahkan.");
            return redirect('/layanan_daftar_super');
        }
    }

    public function updateLayanan_super(Request $request)
    {
        $faskes_layanan_data = new Faskes_Layanan();

        $faskes  = $request->get('m_idnamatempat');
        $layanan = $request->get('m_layanan');

        if($faskes == null || $layanan == null) {
            $request->session()->flash('gagal', "Maaf, layanan tidak boleh kosong.");
            return redirect('/layanan_daftar_super');
        }
        else {
            $tfidf_data = new Pencarian_TFIDF();
            $this->makeToTFIDFupdateFitur($faskes, 0, $tfidf_data);

            $faskes_layanan_data->a_deleteLayanan($faskes);
            $faskes_layanan_data->a_insertLayanan($faskes, $layanan);

            $kalimat_bersih = array();
            $fitur_query = $layanan_data->getAllLayananbyIDFitur($layanan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_layanan;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, layanan telah diperbarui.");
            return redirect('/layanan_daftar_super');
        }
    }

    public function tambahNamaLayanan_super(Request $request)
    {
        $layanan_data = new Layanan();

        $namaLayanan = $request->get('m_namalayanan');

        if($namaLayanan == null) {
            $request->session()->flash('gagal', "Maaf, nama layanan tidak boleh kosong.");
            return redirect('/layanan_tambah_super');
        }
        else {
            $layanan_data->a_tambahNamaLayanan($namaLayanan);
            $request->session()->flash('sukses', "Terimakasih, nama layanan telah ditambahkan.");
            return redirect('/layanan_tambah_super');
        }
    }

    public function updateNamaLayanan_super(Request $request)
    {
        $layanan_data = new Layanan();

        $id          = $request->get('m_idlayanan');
        $namaLayanan = $request->get('m_namalayanan');

        if($namaLayanan == null) {
            $request->session()->flash('gagal', "Maaf, nama layanan tidak boleh kosong.");
            return redirect('/layanan_data_super');
        }
        else {
            $layanan_data->a_updateNamaLayanan($id, $namaLayanan);
            $request->session()->flash('sukses', "Terimakasih, nama layanan telah diperbarui.");
            return redirect('/layanan_data_super');
        }
    }

    public function statusLayanan_super(Request $request)
    {
        $layanan_data = new Layanan();

        $id     = $request->get('m_idlayanan');
        $status = $request->get('m_status');

        if($status == null) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/layanan_data_super');
        }
        else {
            $layanan_data->a_statusLayanan($status, $id);
            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/layanan_data_super');
        }
    }
    /* Layanan */


    /* Asuransi */
    public function asuransiDaftar_super()
    {
        $allDataAsuransi = Faskes_Asuransi::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $asuransi_data = new Asuransi();
        $asuransi = $asuransi_data->getAllAsuransi();

        $users_data = new User();
        $users = $users_data->getAllUsers();

        return view('app_superadmin/asuransi_daftar', compact('allDataAsuransi', 'faskes', 'asuransi', 'users'));
    }

    public function asuransiTambah_super()
    {
        $allDataAsuransi = Faskes_Asuransi::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $asuransi_data = new Asuransi();
        $asuransi = $asuransi_data->getAllAsuransi();

        return view('app_superadmin/asuransi_tambah', compact('allDataAsuransi', 'faskes', 'asuransi'));
    }

    public function asuransiData_super()
    {
        $asuransi_data = Asuransi::all();

        return view('app_superadmin/asuransi_data', compact('asuransi_data'));
    }

    public function insertAsuransi_super(Request $request)
    {
        $asuransi_data = new Asuransi();
        $faskes_asuransi_data = new Faskes_Asuransi();

        $faskes     = $request->get('m_namatempat');
        $asuransi   = $request->get('m_asuransi');

        if($faskes == null || $asuransi == null) {
            $request->session()->flash('gagal', "Maaf, asuransi tidak boleh kosong.");
            return redirect('/asuransi_daftar_super');
        }
        else {
            $faskes_asuransi_data->a_insertAsuransi($faskes, $asuransi);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = array();
            $fitur_query = $asuransi_data->getAllAsuransibyIDFitur($asuransi);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_asuransi;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, asuransi telah ditambahkan.");
            return redirect('/asuransi_daftar_super');
        }
    }

    public function updateAsuransi_super(Request $request)
    {
        $asuransi_data = new Asuransi();
        $faskes_asuransi_data = new Faskes_Asuransi();

        $faskes   = $request->get('m_idnamatempat');
        $asuransi = $request->get('m_asuransi');

        if($faskes == null || $asuransi == null) {
            $request->session()->flash('gagal', "Maaf, asuransi tidak boleh kosong.");
            return redirect('/asuransi_daftar_super');
        }
        else {
            $tfidf_data = new Pencarian_TFIDF();
            $this->makeToTFIDFupdateFitur($faskes, 2, $tfidf_data);

            $faskes_asuransi_data->a_deleteAsuransi($faskes);
            $faskes_asuransi_data->a_insertAsuransi($faskes, $asuransi);

            $kalimat_bersih = array();
            $fitur_query = $asuransi_data->getAllAsuransibyIDFitur($asuransi);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih[] = $fitur_getData->nama_asuransi;
            }
            foreach($kalimat_bersih as $data) {
                $this->makeToTFIDFfitur($data, 0, $faskes);
            }

            $request->session()->flash('sukses', "Terimakasih, asuransi telah diperbarui.");
            return redirect('/asuransi_daftar_super');
        }
    }

    public function tambahNamaAsuransi_super(Request $request)
    {
        $asuransi_data = new Asuransi();

        $namaAsuransi = $request->get('m_namaasuransi');
        $keterangan = $request->get('m_keterangan');

        if($namaAsuransi == null || $keterangan == null) {
            $request->session()->flash('gagal', "Maaf, nama asuransi tidak boleh kosong.");
            return redirect('/asuransi_tambah_super');
        }
        else {
            $asuransi_data->a_tambahNamaAsuransi($namaAsuransi, $keterangan);
            $request->session()->flash('sukses', "Terimakasih, nama asuransi telah ditambahkan.");
            return redirect('/asuransi_tambah_super');
        }
    }

    public function updateNamaAsuransi_super(Request $request)
    {
        $asuransi_data = new Asuransi();

        $id           = $request->get('m_idasuransi');
        $namaAsuransi = $request->get('m_namaasuransi');
        $keterangan   = $request->get('m_keterangan');

        if($namaAsuransi == null) {
            $request->session()->flash('gagal', "Maaf, nama asuransi tidak boleh kosong.");
            return redirect('/asuransi_data_super');
        }
        else {
            $asuransi_data->a_updateNamaAsuransi($id, $namaAsuransi, $keterangan);
            $request->session()->flash('sukses', "Terimakasih, nama asuransi telah diperbarui.");
            return redirect('/asuransi_data_super');
        }
    }

    public function statusAsuransi_super(Request $request)
    {
        $asuransi_data = new Asuransi();

        $id     = $request->get('m_idasuransi');
        $status = $request->get('m_status');

        if($status == null) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/asuransi_data_super');
        }
        else {
            $asuransi_data->a_statusAsuransi($status, $id);
            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/asuransi_data_super');
        }
    }
    /* Asuransi */


    /* Dokter */
    public function dokterDaftar_super()
    {
        $allDataFaskesPenyakitDokter = Faskes_Penyakit_Dokter::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $penyakit_data = new Penyakit();
        $penyakit = $penyakit_data->getAllPenyakit();

        $dokter_data = new Dokter();
        $dokter = $dokter_data->getAllDokter();

        $users_data = new User();
        $users = $users_data->getAllUsers();

        return view('app_superadmin/dokter_daftar', compact('allDataFaskesPenyakitDokter', 'faskes', 'penyakit', 'dokter', 'users'));
    }

    public function dokterTambah_super()
    {
        $allDataDokter = Faskes_Penyakit_Dokter::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $penyakit_data = new Penyakit();
        $penyakit = $penyakit_data->getAllPenyakit();

        $dokter_data = new Dokter();
        $dokter = $dokter_data->getAllDokter();

        return view('app_superadmin/dokter_tambah', compact('allDataDokter', 'faskes', 'penyakit', 'dokter'));
    }

    public function dokterData_super()
    {
        $dokter_data = Dokter::all();

        $users_data = new User();
        $users = $users_data->getAllUsers();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        return view('app_superadmin/dokter_data', compact('dokter_data', 'users', 'faskes'));
    }

    public function insertDokter_super(Request $request)
    {
        $faskes_penyakit_dokter_data = new Faskes_Penyakit_Dokter();

        $faskes   = $request->get('m_namatempat');
        $dokter   = $request->get('m_namadokter');
        $penyakit = $request->get('m_penyakit');

        if($faskes == null || $dokter == null || $penyakit == null) {
            $request->session()->flash('gagal', "Maaf, dokter dan penyakit tidak boleh kosong.");
            return redirect('/dokter_daftar_super');
        }
        else {
            $faskes_penyakit_dokter_data->a_deleteDokter($faskes, $dokter);
            $faskes_penyakit_dokter_data->a_insertDokter($faskes, $penyakit, $dokter);
            $request->session()->flash('sukses', "Terimakasih, dokter dan penyakit telah ditambahkan.");
            return redirect('/dokter_daftar_super');
        }
    }

    public function updateDokter_super(Request $request)
    {
        $faskes_penyakit_dokter_data = new Faskes_Penyakit_Dokter();

        $faskes   = $request->get('m_idnamatempat');
        $dokter   = $request->get('m_namadokter');
        $penyakit = $request->get('m_penyakit');

        if($faskes == null || $dokter == null || $penyakit == null) {
            $request->session()->flash('gagal', "Maaf, dokter dan penyakit tidak boleh kosong.");
            return redirect('/dokter_daftar_super');
        }
        else {
            $faskes_penyakit_dokter_data->a_deleteDokter($faskes, $dokter);
            $faskes_penyakit_dokter_data->a_insertDokter($faskes, $penyakit, $dokter);
            $request->session()->flash('sukses', "Terimakasih, dokter dan penyakit telah diperbarui.");
            return redirect('/dokter_daftar_super');
        }
    }

    public function tambahNamaDokter_super(Request $request)
    {
        $dokter_data = new Dokter();

        $namaTempat = $request->get('n_namatempat');
        $namaDokter = $request->get('n_namadokter');

        if($namaTempat == null || $namaDokter == null) {
            $request->session()->flash('gagal', "Maaf, nama dokter tidak boleh kosong.");
            return redirect('/dokter_tambah_super');
        }
        else {
            $dokter_data->a_tambahNamaDokter($namaTempat, $namaDokter);
            $request->session()->flash('sukses', "Terimakasih, nama dokter telah ditambahkan.");
            return redirect('/dokter_tambah_super');
        }
    }

    public function updateNamaDokter_super(Request $request)
    {
        $dokter_data = new Dokter();

        $id         = $request->get('m_iddokter');
        $namaDokter = $request->get('m_namadokter');

        if($namaDokter == null) {
            $request->session()->flash('gagal', "Maaf, nama dokter tidak boleh kosong.");
            return redirect('/dokter_data_super');
        }
        else {
            $dokter_data->a_updateNamaDokter($id, $namaDokter);
            $request->session()->flash('sukses', "Terimakasih, nama dokter telah diperbarui.");
            return redirect('/dokter_data_super');
        }
    }

    public function statusDokter_super(Request $request)
    {
        $dokter_data = new Dokter();

        $id     = $request->get('m_iddokter');
        $status = $request->get('m_status');

        if($status == null) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/dokter_data_super');
        }
        else {
            $dokter_data->a_statusDokter($status, $id);
            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/dokter_data_super');
        }
    }

    public function dataDokter_super(Request $request)
    {
        $dokter_data = Dokter::select('id', 'nama_dokter')->where('faskes_id', $request->id)->get();
        return response()->json($dokter_data);
    }
    /* Dokter */


    /* Penyakit */
    public function penyakitData_super()
    {
        $penyakit_data = Penyakit::all();

        return view('app_superadmin/penyakit_data', compact('penyakit_data'));
    }

    public function tambahNamaPenyakit_super(Request $request)
    {
        $penyakit_data = new Penyakit();

        $namaPenyakit = $request->get('m_namapenyakit');

        if($namaPenyakit == null) {
            $request->session()->flash('gagal', "Maaf, nama penyakit tidak boleh kosong.");
            return redirect('/dokter_tambah_super');
        }
        else {
            $penyakit_data->a_tambahNamaPenyakit($namaPenyakit);
            $request->session()->flash('sukses', "Terimakasih, nama penyakit telah ditambahkan.");
            return redirect('/dokter_tambah_super');
        }
    }

    public function updateNamaPenyakit_super(Request $request)
    {
        $penyakit_data = new Penyakit();

        $id         = $request->get('m_idpenyakit');
        $namaPenyakit = $request->get('m_namapenyakit');

        if($namaPenyakit == null) {
            $request->session()->flash('gagal', "Maaf, nama penyakit tidak boleh kosong.");
            return redirect('/penyakit_data_super');
        }
        else {
            $penyakit_data->a_updateNamaPenyakit($id, $namaPenyakit);
            $request->session()->flash('sukses', "Terimakasih, nama penyakit telah diperbarui.");
            return redirect('/penyakit_data_super');
        }
    }

    public function statusPenyakit_super(Request $request)
    {
        $penyakit_data = new Penyakit();

        $id     = $request->get('m_idpenyakit');
        $status = $request->get('m_status');

        if($status == null) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/penyakit_data_super');
        }
        else {
            $penyakit_data->a_statusPenyakit($status, $id);
            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/penyakit_data_super');
        }
    }

    public function dataPenyakit_super(Request $request)
    {
        $penyakit_data = Penyakit::all();
        $faskes_penyakit_dokter_data = DB::table('faskes_has_penyakit_has_dokter')
                                        ->join('penyakit', 'faskes_has_penyakit_has_dokter.penyakit_id', '=', 'penyakit.id')
                                        ->select('faskes_has_penyakit_has_dokter.penyakit_id', 'penyakit.nama_penyakit')
                                        ->where('dokter_id', $request->id)
                                        ->get();
        return response()->json(array('0' => $faskes_penyakit_dokter_data, '1' => $penyakit_data));
    }
    /* Penyakit */


    /* Peralatan */
    public function peralatanDaftar_super()
    {
        $allDataPeralatan = Faskes_Peralatan::all();

        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $peralatan_data = new Peralatan();
        $peralatan = $peralatan_data->getAllPeralatan();

        $users_data = new User();
        $users = $users_data->getAllUsers();

        return view('app_superadmin/peralatan_daftar', compact('allDataPeralatan', 'faskes', 'peralatan', 'users'));
    }

    public function peralatanTambah_super()
    {
        $faskes_data = new Faskes();
        $faskes = $faskes_data->getAllFaskes();

        $peralatan_data = new Peralatan();
        $peralatan = $peralatan_data->getAllPeralatan();

        return view('app_superadmin/peralatan_tambah', compact('faskes', 'peralatan'));
    }

    public function peralatanData_super()
    {
        $peralatan_data = Peralatan::all();

        return view('app_superadmin/peralatan_data', compact('peralatan_data'));
    }

    public function insertPeralatan_super(Request $request)
    {
        $peralatan_data = new Peralatan();
        $faskes_peralatan_data = new Faskes_Peralatan();

        $faskes     = $request->get('m_namatempat');
        $peralatan  = $request->get('m_peralatan');
        $keterangan = $request->get('m_keterangan');

        if($peralatan == null) {
            $request->session()->flash('gagal', "Maaf, peralatan tidak boleh kosong.");
            return redirect('/peralatan_daftar_super');
        }
        else {
            $faskes_peralatan_data->a_deletePeralatan($faskes, $peralatan);
            $faskes_peralatan_data->a_insertPeralatan($faskes, $peralatan, $keterangan);

            $tfidf_data = new Pencarian_TFIDF();
            $kalimat_bersih = "";
            $fitur_query = $peralatan_data->getAllPeralatanbyID($peralatan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih = $fitur_getData->nama_peralatan;
            }
            $this->makeToTFIDFfitur($kalimat_bersih, 0, $faskes);

            $request->session()->flash('sukses', "Terimakasih, peralatan telah ditambahkan.");
            return redirect('/peralatan_daftar_super');
        }
    }

    public function updatePeralatan_super(Request $request)
    {
        $peralatan_data = new Peralatan();
        $faskes_peralatan_data = new Faskes_Peralatan();

        $faskes     = $request->get('m_idnamatempat');
        $peralatan  = $request->get('m_peralatan');
        $keterangan = $request->get('m_keterangan');

        if($peralatan == null) {
            $request->session()->flash('gagal', "Maaf, peralatan tidak boleh kosong.");
            return redirect('/peralatan_daftar_super');
        }
        else {
            $tfidf_data = new Pencarian_TFIDF();
            $this->makeToTFIDFupdateFitur($faskes, 1, $tfidf_data);

            $faskes_peralatan_data->a_deletePeralatan($faskes, $peralatan);
            $faskes_peralatan_data->a_insertPeralatan($faskes, $peralatan, $keterangan);

            $kalimat_bersih = "";
            $fitur_query = $peralatan_data->getAllPeralatanbyID($peralatan);
            foreach($fitur_query as $fitur_getData) {
                $kalimat_bersih = $fitur_getData->nama_peralatan;
            }
            $this->makeToTFIDFfitur($kalimat_bersih, 0, $faskes);

            $request->session()->flash('sukses', "Terimakasih, peralatan telah diperbarui.");
            return redirect('/peralatan_daftar_super');
        }
    }

    public function tambahNamaPeralatan_super(Request $request)
    {
        $peralatan_data = new Peralatan();

        $namaPeralatan = $request->get('m_namaperalatan');

        if($namaPeralatan == null) {
            $request->session()->flash('gagal', "Maaf, nama peralatan tidak boleh kosong.");
            return redirect('/peralatan_tambah_super');
        }
        else {
            $peralatan_data->a_tambahNamaPeralatan($namaPeralatan);
            $request->session()->flash('sukses', "Terimakasih, nama peralatan telah ditambahkan.");
            return redirect('/peralatan_tambah_super');
        }
    }

    public function updateNamaPeralatan_super(Request $request)
    {
        $peralatan_data = new Peralatan();

        $id            = $request->get('m_idperalatan');
        $namaPeralatan = $request->get('m_namaperalatan');

        if($namaPeralatan == null) {
            $request->session()->flash('gagal', "Maaf, nama peralatan tidak boleh kosong.");
            return redirect('/peralatan_data_super');
        }
        else {
            $peralatan_data->a_updateNamaPeralatan($id, $namaPeralatan);
            $request->session()->flash('sukses', "Terimakasih, nama peralatan telah diperbarui.");
            return redirect('/peralatan_data_super');
        }
    }

    public function statusPeralatan_super(Request $request)
    {
        $peralatan_data = new Peralatan();

        $id     = $request->get('m_idperalatan');
        $status = $request->get('m_status');

        if($status == null) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/peralatan_data_super');
        }
        else {
            $peralatan_data->a_statusPeralatan($status, $id);
            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/peralatan_data_super');
        }
    }

    public function dataPeralatan_super(Request $request)
    {
        $faskes_peralatan_data = Faskes_Peralatan::select('keterangan')->where('peralatan_id', $request->id)->get();
        return response()->json($faskes_peralatan_data);
    }
    /* Peralatan */


    /* Ulasan */
    public function ulasan_super(Request $request)
    {
        $allUlasan = Ulasan::all();
        $faskes_data = new Faskes();
        
        $faskes = $faskes_data->getAllFaskes();

        return view('app_superadmin/ulasan_daftar', compact('allUlasan', 'faskes'));
    }

    public function statusUlasan_super(Request $request)
    {
        $data = new Ulasan();

        $status     = $request->get('n_status');
        $statusID   = $request->get('m_statusid');

        if(empty($data)) {
            $request->session()->flash('gagal', "Maaf, permintaan tidak berhasil dijalankan.");
            return redirect('/ulasan_super');
        }
        else {
            $data->a_statusUlasanSuper($status, $statusID);
            $request->session()->flash('sukses', "Terimakasih, permintaan telah berhasil dijalankan.");
            return redirect('/ulasan_super');
        }
    }
    /* Ulasan */

    /* TF-IDF Fitur*/
    public function makeToTFIDFfitur($kalimat_bersih, $option, $id)
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer = $tokenizerFactory->createDefaultTokenizer();

        $tfidf_data = new Pencarian_TFIDF();

        $temp_tokenize = array();
        $kalimat = array();
        $arrayKata = array();
        $arrayTabelData = array();
        $dft = array();
        $idf = array();
        $tfidf = array();

        $all_data_tfidf = $tfidf_data->getAllDataByFaskesId($id);
        $tokens = $tokenizer->tokenize( $stemmer->stem($kalimat_bersih) );
        foreach ($tokens as $key => $value) {
            if(!(in_array($value, $all_data_tfidf))) {
                if(empty($temp_tokenize)) {
                    $temp_tokenize[] = $value;
                    $tfidf_data->a_insertTFIDFfitur($id, $value, 0);
                }
                else {
                    if(!(in_array($value, $temp_tokenize))) {
                        $temp_tokenize[] = $value;
                        $tfidf_data->a_insertTFIDFfitur($id, $value, 0);
                    }
                }
            }
        }

        if ($option == 0) {
            $faskes_query = Faskes::where('hapus', 0)->get();
            $checkedForLayanan = DB::table('faskes_has_layanan')
                                ->join('faskes', 'faskes_has_layanan.faskes_id', '=', 'faskes.id')
                                ->join('layanan', 'faskes_has_layanan.layanan_id', '=', 'layanan.id')
                                ->select('faskes.id as faskes_id', 'layanan.nama_layanan as nama_layanan')
                                ->where('faskes.hapus', 0)
                                ->get();
            $checkedForPeralatan = DB::table('faskes_has_peralatan')
                                ->join('faskes', 'faskes_has_peralatan.faskes_id', '=', 'faskes.id')
                                ->join('peralatan', 'faskes_has_peralatan.peralatan_id', '=', 'peralatan.id')
                                ->select('faskes.id as faskes_id', 'peralatan.nama_peralatan as nama_peralatan')
                                ->where('faskes.hapus', 0)
                                ->get();
            $checkedForAsuransi = DB::table('faskes_has_asuransi')
                                ->join('faskes', 'faskes_has_asuransi.faskes_id', '=', 'faskes.id')
                                ->join('asuransi', 'faskes_has_asuransi.asuransi_id', '=', 'asuransi.id')
                                ->select('faskes.id as faskes_id', 'asuransi.nama_asuransi as nama_asuransi')
                                ->where('faskes.hapus', 0)
                                ->get();
        } else {
            $faskes_query = Faskes::where('id', '<>', $id)->where('hapus', 0)->get();
            $checkedForLayanan = DB::table('faskes_has_layanan')
                                ->join('faskes', 'faskes_has_layanan.faskes_id', '=', 'faskes.id')
                                ->join('layanan', 'faskes_has_layanan.layanan_id', '=', 'layanan.id')
                                ->select('faskes.id as faskes_id', 'layanan.nama_layanan as nama_layanan')
                                ->where('faskes.id', '<>', $id)
                                ->where('hapus', 0)
                                ->get();
            $checkedForPeralatan = DB::table('faskes_has_peralatan')
                                ->join('faskes', 'faskes_has_peralatan.faskes_id', '=', 'faskes.id')
                                ->join('peralatan', 'faskes_has_peralatan.peralatan_id', '=', 'peralatan.id')
                                ->select('faskes.id as faskes_id', 'peralatan.nama_peralatan as nama_peralatan')
                                ->where('faskes.id', '<>', $id)
                                ->where('hapus', 0)
                                ->get();
            $checkedForAsuransi = DB::table('faskes_has_asuransi')
                                ->join('faskes', 'faskes_has_asuransi.faskes_id', '=', 'faskes.id')
                                ->join('asuransi', 'faskes_has_asuransi.asuransi_id', '=', 'asuransi.id')
                                ->select('faskes.id as faskes_id', 'asuransi.nama_asuransi as nama_asuransi')
                                ->where('faskes.id', '<>', $id)
                                ->where('hapus', 0)
                                ->get();
        }
        
        foreach ($faskes_query as $row) {
            $result = $row->nama_tempat . " " . $row->alamat . " " . $row->deskripsi;
            foreach($checkedForLayanan as $row2) {
                if($row2->faskes_id == $row->id) {
                    $result = $result . " " . $row2->nama_layanan;
                }
            }
            foreach($checkedForPeralatan as $row3) {
                if($row3->faskes_id == $row->id) {
                    $result = $result . " " . $row3->nama_peralatan;
                }
            }
            foreach($checkedForAsuransi as $row4) {
                if($row4->faskes_id == $row->id) {
                    $result = $result . " " . $row4->nama_asuransi;
                }
            }
            $kalimat[$row->id] = $result;
        }

        /* TF-Raw */
        foreach ($kalimat as $key => $value) {
            $tokens = $tokenizer->tokenize( $stemmer->stem($value) );
            foreach ($tokens as $key => $value2) {
                if (isset($arrayKata[$value2])) {
                    $arrayKata[$value2] ++;
                } else {
                    $arrayKata[$value2] = 1;
                }
            }
        }

        /* Sort */
        ksort($arrayKata);

        /* TF-Raw detail per Dokumen */
        foreach ($arrayKata as $key => $value) {
            $arrayTabelData[$key] = array();
            foreach ($kalimat as $key2 => $value2) {
                $arrayTabelData[$key][$key2] = 0;
                $tokens = $tokenizer->tokenize( $stemmer->stem($value2) );
                foreach ($tokens as $key3 => $value3) {
                    if ($key == $value3) {
                        $arrayTabelData[$key][$key2]++;
                    }
                }
            }
        }

        /* DFt + IDF */
        foreach ($arrayKata as $key => $value) {
            $dft[$key] = 0;
            foreach ($kalimat as $key2 => $value2) {
                if($arrayTabelData[$key][$key2] > 0)
                    $dft[$key]++;
            }
            $idf[$key] = log10(count($arrayTabelData[$key])/$dft[$key]);
        }

        /* TF-IDF + Update Jumlah */
        foreach ($arrayKata as $key => $value) {
            $tfidf[$key] = array();
            foreach ($kalimat as $key2 => $value2) {
                $tfidf[$key][$key2] = $arrayTabelData[$key][$key2] * $idf[$key];
                $tfidf_data->a_updateTFIDF($key2, $key, $tfidf[$key][$key2]);
            }
        }
    }

    public function makeToTFIDFupdateFitur($id, $option, $tfidf_data)
    {
        $faskes_query = Faskes::where('id', $id)->first();

        if(!empty($faskes_query)) {
            $result = $faskes_query->nama_tempat . " " . $faskes_query->alamat . " " . $faskes_query->deskripsi;
            $result_option = "";

            $checkedForLayanan = DB::table('faskes_has_layanan')
                                ->join('faskes', 'faskes_has_layanan.faskes_id', '=', 'faskes.id')
                                ->join('layanan', 'faskes_has_layanan.layanan_id', '=', 'layanan.id')
                                ->select('faskes.id as faskes_id', 'layanan.nama_layanan as nama_layanan')
                                ->where('faskes.id', $id)
                                ->get();
            $checkedForPeralatan = DB::table('faskes_has_peralatan')
                                ->join('faskes', 'faskes_has_peralatan.faskes_id', '=', 'faskes.id')
                                ->join('peralatan', 'faskes_has_peralatan.peralatan_id', '=', 'peralatan.id')
                                ->select('faskes.id as faskes_id', 'peralatan.nama_peralatan as nama_peralatan')
                                ->where('faskes.id', $id)
                                ->get();
            $checkedForAsuransi = DB::table('faskes_has_asuransi')
                                ->join('faskes', 'faskes_has_asuransi.faskes_id', '=', 'faskes.id')
                                ->join('asuransi', 'faskes_has_asuransi.asuransi_id', '=', 'asuransi.id')
                                ->select('faskes.id as faskes_id', 'asuransi.nama_asuransi as nama_asuransi')
                                ->where('faskes.id', $id)
                                ->get();

            // 0 Layanan, 1 Peralatan, 2 Asuransi
            foreach($checkedForLayanan as $row) {
                if($row->faskes_id == $faskes_query->id) {
                    if($option == 1 || $option == 2) {
                        $result = $result . " " . $row->nama_layanan;
                    } else {
                        $result_option = $result_option . " " . $row->nama_layanan;
                    }
                }
            }
            foreach($checkedForPeralatan as $row) {
                if($row->faskes_id == $faskes_query->id) {
                    if($option == 0 || $option == 2) {
                        $result = $result . " " . $row->nama_peralatan;
                    } else {
                        $result_option = $result_option . " " . $row->nama_peralatan; 
                    }
                }
            }
            foreach($checkedForAsuransi as $row) {
                if($row->faskes_id == $faskes_query->id) {
                    if($option == 0 || $option == 1) {
                        $result = $result . " " . $row->nama_asuransi;
                    } else {
                        $result_option = $result_option . " " . $row->nama_asuransi; 
                    }
                }
            }

            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer = $stemmerFactory->createStemmer();
            $tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
            $tokenizer = $tokenizerFactory->createDefaultTokenizer();

            $tokenize_all = array();
            $tokenize_option = array();
            $not_in_array_tokenize = array();

            $tokens = $tokenizer->tokenize( $stemmer->stem($result) );
            foreach ($tokens as $key => $value) {
                if(empty($tokenize_all)) {
                    $tokenize_all[] = $value;
                } else {
                    if(!(in_array($value, $tokenize_all))) {
                        $tokenize_all[] = $value;
                    }
                }
            }

            $tokens = $tokenizer->tokenize( $stemmer->stem($result_option) );
            foreach ($tokens as $key => $value) {
                if(empty($tokenize_option)) {
                    $tokenize_option[] = $value;
                } else {
                    if(!(in_array($value, $tokenize_option))) {
                        $tokenize_option[] = $value;
                    }
                }
            }

            for ($i = 0; $i < count($tokenize_option); $i++) {
                if(!(in_array($tokenize_option[$i], $tokenize_all))) {
                    $not_in_array_tokenize[] = $tokenize_option[$i];
                }
            }

            for ($i = 0; $i < count($not_in_array_tokenize); $i++) {
                $tfidf_data->a_deleteTFIDFByKata($id, $not_in_array_tokenize[$i]);
            }
        }
    }
    /* TF-IDF Fitur*/
}