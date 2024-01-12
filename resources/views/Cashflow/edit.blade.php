@extends('layouts.main')

@section('content')
<form action='{{ url('/cashflow/'.$data->id) }}' method='post'>
    @method('PUT')
    @csrf
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <a href="{{ url('/') }}" class="btn btn-secondary">Kembali</a>
        <div class="mb-3 row">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='tanggal' id="tanggal" value="{{ $data->tanggal }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='jenis' id="jenis" value="{{ $data->jenis }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='nominal' id="nominal" value="{{ $data->nominal }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='keterangan' id="keterangan" value="{{ $data->keterangan }}">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
            </div>
        </div>
    </div>
</form>
@endsection


