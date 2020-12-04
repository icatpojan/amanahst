@extends('layouts.admin')

@section('title')
    <title>Detail pesanan</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">View Order</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Detail pesanan

                                <!-- TOMBOL UNTUK MENERIMA PEMBAYARAN -->
                                {{-- <div class="float-right">
                                    <!-- TOMBOL INI HANYA TAMPIL JIKA STATUSNYA 1 DARI ORDER DAN 0 DARI PEMBAYARAN -->
                                    @if ($order_details->status == 1 && $order_details->payment->status == 0)
                                    <a href="{{ route('orders.approve_payment', $order_details->invoice) }}" class="btn btn-primary btn-sm">Terima Pembayaran</a>
                                    @endif
                                </div> --}}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                              
                                <!-- BLOCK UNTUK MENAMPILKAN DATA PELANGGAN -->
                                <div class="col-md-6">
                                    <h4>Detail Pelanggan</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Nama Pelanggan</th>
                                            <td>{{ $order_details->product_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telp</th>
                                            <td>{{ $order_details->order_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $order_details->jumlah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Order Status</th>
                                            <td>{!! $order_details->status_label !!}</td>
                                        </tr>
                                        <!-- FORM INPUT RESI HANYA AKAN TAMPIL JIKA STATUS LEBIH BESAR 1 -->
                                        @if ($order_details->status > 1)
                                        <tr>
                                            <th>Nomor Resi</th>
                                            <td>
                                                @if ($order_details->status == 2)
                                              
                                                @else
                                                {{ $order_details->jumlah_harga }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                {{-- <div class="col-md-6">
                                    <h4>Detail Pembayaran</h4>
                                    @if ($order_details->status != 0)
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Nama Pengirim</th>
                                            <td>{{ $order_details->payment->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank Tujuan</th>
                                            <td>{{ $order_details->payment->transfer_to }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Transfer</th>
                                            <td>{{ $order_details->payment->transfer_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bukti Pembayaran</th>
                                            <td><a target="_blank" href="{{ asset('storage/payment/' . $order_details->payment->proof) }}">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{!! $order_details->payment->status_label !!}</td>
                                        </tr>
                                    </table>
                                    @else
                                    <h5 class="text-center">Belum Konfirmasi Pembayaran</h5>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <h4>Detail Produk</h4>
                                    <table class="table table-borderd table-hover">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Quantity</th>
                                            <th>Harga</th>
                                            <th>Berat</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        @foreach ($order_details->details as $row)
                                        <tr>
                                            <td>{{ $row->product->name }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>Rp {{ number_format($row->price) }}</td>
                                            <td>{{ $row->weight }} gr</td>
                                            <td>Rp {{ $row->qty * $row->price }}</td>
                                        </tr>
                                        @endforeach --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
