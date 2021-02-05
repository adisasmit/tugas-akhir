<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;
use App\Models\Catatan\TransaksiProyek;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perusahaan = Perusahaan::with('user')->get()->where('kode_perusahaan', '=', Auth::user()->kode_perusahaan)->first();
        $items = Gudang::where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
        $inventoris = Gudang::where('id_perusahaan', '=', Auth::user()->id_perusahaan)
            ->where('jenis', '=', 'Masuk')->get();
        // dd($inventoris);
        return view('catatan/gudang', compact('items', 'perusahaan', 'inventoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        // dd($request);
        //pengurangan
        // $tr_proyek = TransaksiProyek::find($request->id);
        // $jml = floatval(str_replace(",","",$request->jumlah));
        // $pakai = floatval(str_replace(",","",$request->jumlah_dibayar));
        // $sisa = $jml - $terbayar;
        // $jenis = '-';
        // if($sisa > 0 && $akun->jenis == 'Keluar') $jenis = 'Utang';
        // else if($sisa > 0 && $akun->jenis == 'Masuk') $jenis = 'Piutang';


        // dd($request);
        $perusahaan = Perusahaan::with('user')->get()->where('kode_perusahaan', '=', Auth::user()->kode_perusahaan)->first();
        $parent = Gudang::find($request->id_parent);
        if (!empty($perusahaan)) {
            Gudang::create([
                'id_parent' => $request->id_parent,
                'nama_barang' => $parent->nama_barang,
                'satuan' => $parent->satuan,
                'jumlah' => $request->jumlah,
                'jenis' => 'Keluar',
                // 'harga_satuan' => $request->harga_satuan,
                'id_perusahaan' => $perusahaan->id,
                'sisa' => $request->sisa,
                'keterangan' => $request->keterangan
            ]);
            return redirect()->route('gudang');
        } else {
            //kalau belum ada perusahaan, data tidak bisa masuk hehehe
            return redirect()->route('gudang');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        // $itemGudang = Gudang::find($id);
        // $itemGudang = Gudang::where('id', $id)->first();

        Gudang::where('id', $id)->update([
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'jumlah' => $request->jumlah,
            'sisa' => $request->sisa,
            'keterangan' => $request->keterangan
            // 'harga_satuan' => $request->harga_satuan,
        ]);

        // $itemGudang->nama_barang = $request->nama_barang;
        // $itemGudang->satuan = $request->satuan;
        // $itemGudang->jumlah = $request->jumlah;
        // $itemGudang->harga_satuan = $request->harga_satuan;
        // $itemGudang->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gudang::where('id', $id)->destroy();
    }

    public function pageGudang($date_range = null)
    {
        if (!(is_null($date_range))) {
            $separated = explode(' - ', $date_range);
            $start = Carbon::CreateFromFormat('d-m-Y', $separated[0])->startOfDay();
            $end = Carbon::CreateFromFormat('d-m-Y', $separated[1])->endOfDay();

            // $catatan_gudangs = Gudang::with('perusahaan', 'transaksi')
            //     ->where('id_perusahaan', '=', Auth::user()->id_perusahaan)
            //     ->whereBetween('catatan_transaksi_proyeks.tanggal_transaksi', [$start, $end])
            //     ->get();
            // $catatan_gudangs = DB::select('select g.* from gudangs g, perusahaans p, catatan_transaksi_proyeks c 
            // where p.id = g.id_perusahaan 
            // and c.id = g.id_transaksi')
            // ->whereBetween('c.tanggal_transaksi', [$start, $end])
            // ->get();

            $catatan_gudangs = DB::table('gudangs')
                ->join('perusahaans', 'perusahaans.id', '=', 'gudangs.id_perusahaan')
                ->join('catatan_transaksi_proyeks', 'catatan_transaksi_proyeks.id', '=', 'gudangs.id_transaksi')
                ->select('gudangs.*')
                ->whereBetween('catatan_transaksi_proyeks.tanggal_transaksi', [$start, $end])
                ->get();

            if (!(is_null($date_range))) {
                $date_range = str_replace('-', '/', $date_range);
                $date_range = str_replace(' / ', ' - ', $date_range);
                // dd($start, $end, $catatan_tr_proyeks);
            } else {
                $catatan_gudangs = Gudang::with('perusahaan', 'transaksi')
                    ->where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
            }

            //     $inventoris = Gudang::where('id_perusahaan', '=', Auth::user()->id_perusahaan)
            //         ->where('jenis', '=', 'Masuk')->get();
            //     // $transaksis = Pemasok::where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
            //     // $proyeks = Proyek::where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
            //     // $akun_neracas = Gudang::where('id_perusahaan', '=', Auth::user()->id_perusahaan)
            //     //     ->where('jenis_akun', '!=', 'Lainnya')
            //     //     ->get();

            //     // $kas_sum = Gudang::where('id_perusahaan', '=', Auth::user()->id_perusahaan)
            //     //     ->where('jenis_akun', '=', 'Kas')
            //     //     ->sum('saldo');

            //     // $bank_sum = AkunNeracaSaldo::where('id_perusahaan', '=', Auth::user()->id_perusahaan)
            //     //     ->where('jenis_akun', '=', 'Bank')
            //     //     ->sum('saldo');
            //     //dd($date_range);
            //     $perusahaan = Perusahaan::with('user')->get()->where('kode_perusahaan', '=', Auth::user()->kode_perusahaan)->first();
            //     return view('catatan/gudang', [
            //         'items' => $catatan_gudangs,
            //         'date_range' => $date_range,
            //         'inventoris' => $inventoris,
            //         'perusahaan' => $perusahaan,

            //     ]);
        }
    }
}
