<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\rw;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class RwController extends Controller
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
        $rw = rw::with('kelurahan')->get();
        return view('rw.index',compact('rw'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelurahan = Kelurahan::all();
        return view('rw.create',compact('kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:rws',
        ],[
            'nama.required' => 'Nama RW Tidak Boleh Kosong',
            'nama.unique' => 'Nama RW Sudah Terdaftar'
        ]);
        $rw= new rw();
        $rw->id_kelurahan = $request->nama_kelurahan;
        $rw->nama = $request->nama;
        $rw->save();
        return redirect()->route('rw.index')
            ->with(['message'=>'Data Berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rw = rw::findOrFail($id);
        return view('rw.show',compact('rw'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelurahan = Kelurahan::all();
        $rw = rw::findOrFail($id);
        return view('rw.edit',compact('rw','kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rw = rw::findOrFail($id);
        $rw->id_kelurahan = $request->nama_kelurahan;
        $rw->nama = $request->nama;
        $rw->save();
        return redirect()->route('rw.index')
            ->with(['message'=>'Data Berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rw = rw::findOrFail($id)->delete();
        return redirect()->route('rw.index')
                        ->with(['message1'=>'Berhasil dihapus']);
    }
}