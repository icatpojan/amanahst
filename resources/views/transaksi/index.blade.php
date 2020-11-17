@extends('layouts.admin')

@section('title')
<title>Daftar Pesanan</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Orders</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Pesanan
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <!-- FORM UNTUK FILTER DAN PENCARIAN -->
                            <form action="{{ route('transaksi.index') }}" method="get">
                                <div class="input-group mb-3 col-md-6 float-right">
                                    <select name="status" class="form-control mr-3">
                                        <option value="">Pilih Status</option>
                                        <option value="0">Baru</option>
                                        <option value="1">Confirm</option>
                                        <option value="2">Proses</option>
                                        <option value="3">Dikirim</option>
                                        <option value="4">Selesai</option>
                                    </select>
                                    <input type="text" name="q" class="form-control" placeholder="Cari..." value="{{ request()->q }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <!-- FORM UNTUK FILTER DAN PENCARIAN -->

                            <!-- TABLE UNTUK MENAMPILKAN DATA ORDER -->
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID transaksi</th>
                                            <th>Pelanggan</th>
                                            <th>jumlah harga</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($Order as $row)
                                        <tr>
                                            <td><strong>{{ $row->id }}</strong></td>
                                            <td>
                                                <strong>{{ $row->customer_id }}</strong><br>
                                                <label><strong>Telp:</strong> {{ $row->nomor_telpon }}</label><br>
                                            </td>
                                            </td>
                                            <td>{{ $row->jumlah_harga }}</td>
                                            <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                {!! $row->status_label !!}
                                            </td>
                                            <td>
                                                <form action="{{ route('transaksi.destroy', $row->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <a href="{{ route('transaksi.view', $row->invoice) }}" class="btn btn-warning btn-sm">Lihat</a> --}}
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection