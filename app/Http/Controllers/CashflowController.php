<?php

namespace App\Http\Controllers;

use App\Models\Cashflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CashflowController extends Controller
{
   
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        // dd($katakunci);
        if (strlen($katakunci)) {
            # code...
            $data = Cashflow::where('keterangan','like',"%$katakunci%")
            ->orWhere('tanggal','like',"%$katakunci%")
            ->paginate(5);
        }else{
            $data = Cashflow::orderBy('tanggal','asc')->paginate(5);
        }
        // Ambil jumlah nominal dengan kategori pengeluaran pada bulan saat ini
        $currentMonth = now()->format('Y-m');
        $pengeluaran = Cashflow::where('jenis', 'pengeluaran')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$currentMonth])
            ->sum('nominal');

        $pemasukan = Cashflow::where('jenis', 'pemasukan')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$currentMonth])
            ->sum('nominal');



        return view('Cashflow.index', [
            'data2' => $data,
            'jumlahPengeluaran' => $pengeluaran,
            'jumlahPemasukan' => $pemasukan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Cashflow.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //    mengembalikan data yang telah dimasukan oleh user jadi nggak hilang apabila menekan tombol submit dan ada error yang ditimbulakan
        Session::flash('tanggal', $request->tanggal);
        Session::flash('jenis', $request->jenis);
        Session::flash('nominal', $request->nominal);
        Session::flash('keterangan', $request->keterangan);

        //validasi agar data harus diisi terlebih dahulu
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string',
            'nominal' => 'required|integer',
            'keterangan' => 'required|string',
        ], [
            'tanggal.required' => 'Tanggal Wajib diisi',
            'jenis.required' => 'jenis Wajib diisi',
            'nominal.required' => 'nominal Wajib diisi',
            'keterangan.required' => 'keterangan Wajib diisi',
        ]);
        $data = [
            // nama kolom di tabel mahasiswa
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ];
        Cashflow::create($data);

        // return 'data berhasil masuk, coba cek database';
        return redirect()->to('/')->with('success', 'berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Cashflow::where('id',$id)->first();
        return view('Cashflow.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string',
            'nominal' => 'required|integer',
            'keterangan' => 'required|string',
        ], [
            'tanggal.required' => 'Tanggal Wajib diisi',
            'jenis.required' => 'jenis Wajib diisi',
            'nominal.required' => 'nominal Wajib diisi',
            'keterangan.required' => 'keterangan Wajib diisi',
        ]);
        $data = [
            // nama kolom di tabel mahasiswa
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ];
        // mahasiswa::create($data);
        Cashflow::where('id',$id)->update($data);

        // return 'data berhasil masuk, coba cek database';
        return redirect()->to('cashflow')->with('success', 'berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // return 'return dari delete';
        Cashflow::where('id', $id)->delete();
        return redirect()->to('/')->with('success', 'berhasil delete data');
    }
}