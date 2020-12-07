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
                                <h1 class="card-title">
                                    Data User
                                </h1>
                            </div>
                            <div class="card-body">
                                <img src="{{ $shop->image }}" alt="toko terlarang">
                                <h3>Pemilik toko :{{ $shop->name }}</h3>
                                <h5>{{ $shop->description }}</h5>
                                <p>alamat{{ $shop->alamat }}</p>
                                <p>dibuat pada{{ $shop->create_at }}</p>
                                <P>jumlah produk:{{ $Product }}</P>
                                <p>dengan penghasilan:Rp.{{ number_format($Order_details) }}</p>
                            <a href="{{ route('pembeli.index') }}" class="btn btn-warning"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
