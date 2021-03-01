<?php

namespace App\Http\Controllers\Api;
use App\Models\Kasus2;
use App\Models\Provinsi;
use App\Models\Kelurahan;
use App\Models\kecamatan;
use App\Models\RW;
use App\Models\Kota;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // BERDASARKAN DATA API GLOBAL
    public function global() 
    {
        $response = Http::get('https://api.kawalcorona.com/')->json();
        $data = [
            'Success'            => true,
            'Data Api Global'   => $response,
            'Message'           => 'Data Api Global Ditampilkan'        
        ];
        return response()->json($data, 200);

}
    public function indonesia(){
        $positif = DB::table('rws')
                    ->select('kasus2s.jumlah_positif',
                    'kasus2s.jumlah_sembuh', 'kasus2s.jumlah_meninggal')
                    ->join('kasus2s', 'rws.id', '=', 'kasus2s.id_rw')
                    ->sum('kasus2s.jumlah_positif');
        
        $sembuh = DB::table('rws')
                    ->select('kasus2s.jumlah_positif',
                    'kasus2s.jumlah_sembuh', 'kasus2s.meninggal')
                    ->join('kasus2s', 'rws.id', '=', 'kasus2s.id_rw')
                    ->sum('kasus2s.jumlah_sembuh');
    
        $meninggal = DB::table('rws')
                    ->select('kasus2s.jumlah_positif',
                    'kasus2s.jumlah_sembuh', 'kasus2s.jumlah_meninggal')
                    ->join('kasus2s', 'rws.id', '=', 'kasus2s.id_rw')
                    ->sum('kasus2s.jumlah_meninggal');
    
    
        $res = [
            'success' => true,
            'data' => 'Data Kasus Indonesia',
            'jumlah_positif' => $positif,
            'sembuh' => $sembuh,
            'meninggal' => $meninggal,
            'message' => 'Data Kasus Ditampilkan'
        ];
        return response()->json($res,200);
    }

  public function provinsi($id){
    $positif = DB::table('provinsis')
    ->join('kotas', 'kotas.id_provinsi', '=', 'provinsis.id')
    ->join('kecamatans', 'kecamatans.id_kota', '=', 'kotas.id')
    ->join('kelurahans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
    ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
    ->join('kasus2s', 'kasus2s.id_rw', '=', 'rws.id')
    ->select('kasus2s.jumlah_positif')
    ->where('provinsis.id',$id)
    ->sum('kasus2s.jumlah_positif');

     $sembuh = DB::table('provinsis')
     ->join('kotas', 'kotas.id_provinsi', '=', 'provinsis.id')
     ->join('kecamatans', 'kecamatans.id_kota', '=', 'kotas.id')
     ->join('kelurahans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
     ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
     ->join('kasus2s', 'kasus2s.id_rw', '=', 'rws.id')
     ->select('kasus2s.jumlah_sembuh')
     ->where('provinsis.id',$id)
     ->sum('kasus2s.jumlah_sembuh');

     $meninggal = DB::table('provinsis')
     ->join('kotas', 'kotas.id_provinsi', '=', 'provinsis.id')
     ->join('kecamatans', 'kecamatans.id_kota', '=', 'kotas.id')
     ->join('kelurahans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
     ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
     ->join('kasus2s', 'kasus2s.id_rw', '=', 'rws.id')
     ->select('kasus2s.jumlah_meninggal')
     ->where('provinsis.id',$id)
     ->sum('kasus2s.jumlah_meninggal');

     $provinsi = Provinsi::whereId($id)->first();

    $res = [
        'success' => true,
        'nama_provinsi' => $provinsi['nama_provinsi'],
        'jumlah_positif' => $positif,
        'jumlah_sembuh' => $sembuh,
        'jumlah_meninggal' => $meninggal,
        'message' => 'Data Berhasil DItampilkan'
    ];
    return response()->json($res, 200);
}

public function provinsikasus(){
    $var = DB::table('provinsis')
    ->join('kotas', 'kotas.id_provinsi', '=', 'provinsis.id')
    ->join('kecamatans', 'kecamatans.id_kota', '=', 'kotas.id')
    ->join('kelurahans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
    ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
    ->join('kasus2s', 'kasus2s.id_rw', 'rws.id')
    ->select('nama_provinsi',
        DB::raw('sum(kasus2s.jumlah_positif) as jumlah_Positif'),
        DB::raw('sum(kasus2s.jumlah_sembuh) as jumlah_sembuh'),
        DB::raw('sum(kasus2s.jumlah_meninggal) as jumlah_meninggal'),
    )
    ->groupBy('nama_provinsi')
    ->get();

$data = [
    'status' => true,
    'message' => 'Menampilkan Provinsi',
    'data' => $var,
];

return response()->json($data, 200);
}

public function hari()
    {

        $kasus2 = Kasus2::get('created_at')->last();
        $jumlah_positif = kasus2::where('tanggal', date('Y-m-d'))->sum('jumlah_positif');
        $jumlah_sembuh = kasus2::where('tanggal', date('Y-m-d'))->sum('jumlah_sembuh');
        $jumlah_meninggal = kasus2::where('tanggal', date('Y-m-d'))->sum('jumlah_meninggal');

        $join = DB::table('kasus2s')
                    ->select('jumlah_positif', 'jumlah_sembuh', 'jumlah_meninggal')
                    ->join('rws', 'kasus2s.id_rw', '=', 'rws.id')
                    ->get();
        $arr2 = [
            'Data' => 'DATA KASUS HARI INI',
            'jumlah_positif' =>$jumlah_positif,
            'jumlah_sembuh' =>$jumlah_sembuh,
            'jumlah_meninggal' =>$jumlah_meninggal,
        ];
        $arr1 = [
                'jumlah_positif' =>$jumlah_positif,
                'jumlah_sembuh' =>$jumlah_sembuh,
                'jumlah_meninggal' =>$jumlah_meninggal,
        ];
        $arr = [
            'status' => 200,
            'data' => [
                'Hari ini' => $arr2,
                'total' =>$arr1
            ],
            'message' => 'Berhasil'
        ];
        return response()->json($arr, 200);
    }
    public function kota(){
        $kota = DB::table('kotas')
        ->join('kecamatans', 'kecamatans.id_kota', '=', 'kotas.id')
        ->join('kelurahans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
        ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
        ->join('kasus2s', 'kasus2s.id_rw', 'rws.id')
        ->select( 'nama_kota',
               DB::raw('sum(kasus2s.jumlah_positif) as jumlah_Positif'),
               DB::raw('sum(kasus2s.jumlah_sembuh) as sejumlah_mbuh'),
               DB::raw('sum(kasus2s.jumlah_meninggal) as jumlah_meninggal'),
           )
       ->groupBy('nama_kota')
       ->get();
    
    $res = [
    'status' => true,
    'Data Kota' => $kota,
    'message' => 'Menampilkan Kota',
    ];
    
    return response()->json($res, 200);
    }
    public function kecamatan(){
        $kecamatan = DB::table('kecamatans')
        ->join('kelurahans', 'kelurahans.id_kecamatan', '=', 'kecamatans.id')
        ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
        ->join('kasus2s', 'kasus2s.id_rw', 'rws.id')
        ->select( 'nama_kecamatan',
               DB::raw('sum(kasus2s.jumlah_positif) as jumlah_Positif'),
               DB::raw('sum(kasus2s.jumlah_sembuh) as jumlah_sembuh'),
               DB::raw('sum(kasus2s.jumlah_meninggal) as jumlah_meninggal'),
           )
       ->groupBy('nama_kecamatan')
       ->get();
    
    $res = [
    'status' => true,
    'Data Kota' => $kecamatan,
    'message' => 'Menampilkan Kecamatan',
    ];
    
    return response()->json($res, 200);
    }
    public function kelurahan(){
    
        $kelurahan = DB::table('kelurahans')
        ->join('rws', 'rws.id_kelurahan', '=', 'kelurahans.id')
        ->join('kasus2s', 'kasus2s.id_rw', 'rws.id')
        ->select( 'nama_kelurahan',
               DB::raw('sum(kasus2s.jumlah_positif) as jumlah_Positif'),
               DB::raw('sum(kasus2s.jumlah_sembuh) as jumlah_sembuh'),
               DB::raw('sum(kasus2s.jumlah_meninggal) as jumlah_meninggal'),
           )
       ->groupBy('nama_kelurahan')
       ->get();
    
    $res = [
    'status' => true,
    'Data Kota' => $kelurahan,
    'message' => 'Menampilkan kelurahan',
    ];
    
    return response()->json($res, 200);
}
public function rw()
    {
        //Data Kota 
        $data = DB::table('rws')
        ->join('kasus2s','kasus2s.id_rw', '=', 'rws.id')
        ->select('rws.nama',
        DB::raw('sum(kasus2s.jumlah_positif) as jumlah_positif'),
        DB::raw('sum(kasus2s.jumlah_meninggal) as jumlah_meninggal'),
        DB::raw('sum(kasus2s.jumlah_sembuh) as jumlah_sembuh'))
        ->groupBy('nama')
        ->get();
                $res = [
                    'succsess' => true,
                    'Data' => $data,
                    'message' => 'Data Kasus Di Tampilkan'
                ];
                return response()->json($res,200);
    }
}
