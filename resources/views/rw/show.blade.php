@extends('master.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Data Rw') }}</div>

                <div class="card-body">
                     <div class="form-group">
                        <label for="">Nama Kelurahan</label>
                        <input type="text" name="nama_kelurahana" class="form-control" value="{{$rw->kelurahan->nama_kelurahan}}" readonly>
                    </div>
                      <div class="form-group">
                    <div class="mb-12>
                        <label for="exampleInputPassword1" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="nama"
                        value="{{$rw->nama}}"readonly>
                    </div>
                     </div>
                     <div class="form-group">
                         <a href="{{route('rw.index')}}" class="btn btn-primary btn-blok">Kembali</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection