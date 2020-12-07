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
                                    Daftar User
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm float-right">Tambah
                                    Admin</a>
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
                                        <input type="text" name="q" class="form-control" placeholder="Cari..."
                                            value="{{ request()->q }}">
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
                                                <th>ID</th>
                                                <th>Pelanggan</th>
                                                <th>nomor telpon</th>
                                                <th>alamat</th>
                                                <th>foto</th>
                                                <th>Tanggal</th>
                                                <th>kode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($User ?? '' as $row)
                                                <b style="color: white">{{ $row->image }}</b>
                                                <tr>
                                                    <td><strong>{{ $row->id }}</strong></td>
                                                    <td><strong>{{ $row->name }}</strong><br>
                                                    <td>{{ $row->nomor_telpon }}</td>
                                                    <td>{{ $row->alamat }}</td>
                                                    <td> <img src="{{ $row->image }}" width="100px" height="100px"
                                                            alt="{{ $row->name }}"></td>
                                                    <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $row->kode }}</td>
                                                    <td>
                                                        <form action="{{ route('pembeli.destroy', $row->id) }}" method="delete">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm">black list</button>
                                                        </form>























                                                        <!-- Button trigger modal -->
                                                        <form action="{{ route('pendapatan', $row->id) }}" method="get">
                                                            <button type="button" class="btn btn-warning mt-2"
                                                                data-toggle="modal" data-target="#staticBackdrop">
                                                                lihat
                                                            </button>

                                                        </form>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                                                            data-keyboard="false" tabindex="-1"
                                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">Modal
                                                                            title</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ $shop }}
                                                                        {{ $Product->name }}
                                                                        Rp.{{ number_format($Order_details) }}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="button"
                                                                            class="btn btn-primary">Understood</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>





























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
