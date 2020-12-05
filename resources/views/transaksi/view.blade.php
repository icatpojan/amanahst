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
                            @forelse ($order_detais as $row)
                            <tr>
                                <b style="color: white">{{ $row->product_id }}</b>
                                <td><strong>{{ $row->product_id }}</strong><br>
                                <td>
                                    <strong><img src="{{ $row->user->image }}" width="100px" height="100px"
                                            alt="{{ $row->name }}">
                                    </strong><br>
                                <td><strong>{{ $row->user->email }}</strong><br>
                                <td><strong>{{ $row->user->alamat }}</strong><br>
                                <td>{{ $row->jumlah_harga }}</td>
                                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                <td>
                                    {!! $row->status_label !!} <br></td>
                                <td>
                                    <form action="{{ route('transaksi.show', $row->id) }}"
                                        method="get">
                                        <input type="submit" class="btn btn-danger" value="lihat">
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
