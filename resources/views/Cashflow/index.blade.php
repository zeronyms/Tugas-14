@extends('layouts.main')
@section('content')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <!-- FORM PENCARIAN -->
        <div class="pb-3">
            <form class="d-flex" action="{{ url('cashflow') }}" method="get">
                <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}"
                    placeholder="Masukkan kata kunci" aria-label="Search">
                <button class="btn btn-secondary" type="submit">Cari</button>
            </form>
        </div>

        <!-- TOMBOL TAMBAH DATA -->
        <div class="pb-3">
            <a href='{{ url('cashflow/create') }}' class="btn btn-primary">+ Tambah Data</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-2">Tanggal</th>
                    <th class="col-md-3">Jenis</th>
                    <th class="col-md-3">Nominal</th>
                    <th class="col-md-2">Keterangan</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = $data2->firstItem();
                @endphp
                @foreach ($data2 as $item)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->nominal }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            <a href='{{ url('cashflow/' . $item->id . '/edit') }}' class="btn btn-warning btn-sm">Edit</a>
                            {{-- <a href='' class="btn btn-danger btn-sm">Del</a> --}}
                            <form onsubmit="return confirm('yakin akan menghapus data?')" class="d-inline" action="{{ url('cashflow/' . $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="submit" class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </tbody>
        </table>
        {{ $data2->links() }}
    </div>
    <section class="container">
        <div class="d-flex justify-content-center gap-4">
            <div class="card">
                <div class="card-body flex-grow-1">
                    <h5 class="text-center">Jumlah Pengeluaran Bulan ini</h1>
                    {{ $jumlahPengeluaran }}
                </div>
            </div>
            <div class="card">
                <div class="card-body flex-grow-1">
                    <h5 class="text-center">Jumlah Pemasukan Bulan ini</h1>
                    {{ $jumlahPemasukan }}
                </div>
            </div>
        </div>
    </section>
@endsection
