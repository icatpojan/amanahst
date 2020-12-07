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
                                </h4>
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th>id order</th>
                                        <th>barang</th>
                                        <th>foto</th>
                                        <th>jumlah pesan</th>
                                        <th>Harga total</th>
                                    </tr>
                                    @foreach ($order_details as $order_detail)
                                        <b style="color: white">{{ $order_detail->product->image }}</b>
                                        <tr>
                                            <td>{{ $order_detail->order_id }}</td>
                                            <td>{{ $order_detail->product->name }}</td>
                                            <td><img src="{{ $order_detail->product->image }}" alt="barang ilegal"></td>
                                            <td>{{ $order_detail->jumlah }}</td>
                                            <td>{{ $order_detail->jumlah_harga }}</td>
                                        </tr>
                                    @endforeach</td>
                                    <a class="btn btn-warning" href="{{ route('transaksi.index') }}">kembali</a>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
