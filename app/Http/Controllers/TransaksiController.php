<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKantor;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function addTransaksiKantor(Request $req) 
    {
        TransaksiKantor::create([
            'tgl_transaksi' =>  $req->tgl_transaksi, 
            'nama_transaksi' => $req->nama_transaksi,
            'keterangan' => $req->keterangan,
            'jenis_simpanan' => $req->jenis_simpanan,
            'jenis_transaksi' =>  DB::table('akun_transaksi_kantors')->select('jenis')->where('nama', '=', $req->nama_transaksi),
            'jumlah' => floatval(str_replace(",","",$req->jumlah)),
            'id_perusahaan' => (User::find(Auth::user()->id))->id_perusahaan,
        ]);
        return redirect()->route('transaksi_kantor');
    }

    function addTransaksiProyek(Request $req) 
    {
        TransaksiKantor::create([
            'tgl_transaksi' =>  $req->tgl_transaksi, 
            'nama_transaksi' => $req->nama_transaksi,
            'nama_pemasok' => $req->nama_pemasok,
            'nama_proyek' => $req->nama_proyek,
            'jenis_proyek' => DB::table('proyeks')->select('jenis')->where('nama', '=', $req->nama_proyek),
            'jenis_simpanan' => $req->jenis_simpanan,
            'jenis_transaksi' =>  DB::table('akun_transaksi_proyeks')->select('jenis')->where('nama', '=', $req->nama_transaksi),
            'jumlah' => floatval(str_replace(",","",$req->jumlah)),
            'dibayar_diterima' => floatval(str_replace(",","",$req->dibayar_diterima)),
            'jumlah' => floatval(str_replace(",","",$req->sisa)),
            'sisa' => $req->utang_piutang,
            'id_perusahaan' => (User::find(Auth::user()->id))->id_perusahaan,
        ]);
        return redirect()->route('transaksi_kantor');
    }
}