<?php

namespace App\Http\Controllers;

use App\Models\Kasus2;
use App\Models\Rw;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class Kasus2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kasus2 = Kasus2::with('rw.kelurahan.kecamatan.kota.provinsi')->get();
        return view('kasus2.index',compact('kasus2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rw = Rw::all();
        return view('kasus2.create',compact('rw'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kasus2= new Kasus2();
        $kasus2->jumlah_positif = $request->positif;
        $kasus2->jumlah_meninggal = $request->meninggal;
        $kasus2->jumlah_sembuh = $request->sembuh;
        $kasus2->tanggal = $request->tanggal;
        $kasus2->id_rw = $request->id_rw;
        $kasus2->save();
        return redirect()->route('kasus2.index')
            ->with(['message'=>'Data Berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kasuse  $kasuse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kasus2 = Kasus2::findOrFail($id);
        return view('kasus2.show',compact('kasus2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kasuse  $kasuse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rw = Rw::all();
        $kasus2 = Kasus2::findOrFail($id);
        return view('kasus2.edit',compact('kasus2','rw'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kasuse  $kasuse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $kasus2 = Kasus2::findOrFail($id);
        $kasus2->jumlah_positif = $request->positif;
        $kasus2->jumlah_meninggal = $request->meninggal;
        $kasus2->jumlah_sembuh = $request->sembuh;
        $kasus2->tanggal = $request->tanggal;
        $kasus2->id_rw = $request->id_rw;
        $kasus2->save();
        return redirect()->route('kasus2.index')
            ->with(['message'=>'Data Berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kasuse  $kasuse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kasus2 = Kasus2::findOrFail($id)->delete();
        return redirect()->route('kasus2.index')
                        ->with(['message1'=>'Berhasil dihapus']);
    }
}