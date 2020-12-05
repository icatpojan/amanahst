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

                                @foreach ($order_details as $order_detail)
                                    {{ $order_detail->order_id }}
                                    {{ $order_detail->jumlah }}
                                    {{ $order_detail->jumlah_harga }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
