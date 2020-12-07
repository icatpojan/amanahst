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
                                {{ $shop }}
                                {{ $Product }}
                                Rp.{{ number_format($Order_details) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
