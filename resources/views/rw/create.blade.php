@extends('master.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Data Rw') }}</div>

                <div class="card-body">
                <form  action="{{route('rw.store')}}" method="post">
                    @csrf
                     <div class="form-group">
                        <label for="">Nama kelurahan</label>
                        <select name="nama_kelurahan" class="form-control" required>
                            @foreach($kelurahan as $data)
                                <option value="{{$data->id}}">{{$data->nama_kelurahan}}</option>
                            @endforeach
                        </select>
                    </div>
                      <div class="form-group">
                    <div class="mb-12>
                        <label for="exampleInputPassword1" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="nama">
                        @if($errors->has('nama'))
                          <span class="text-danger">{{$errors->first('nama')}}</span>
                        @endif
                    </div>
                     </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection