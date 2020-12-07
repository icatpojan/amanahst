@extends('layouts.ecommerce')

@section('title')
    <title>SI AMANAH</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->
    <section class="home_banner_area">
        <div class="overlay"></div>
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content row">
                    <div class="offset-lg-2 col-lg-8">
                        <h3>SI AMANAH
                            <br />TEMPAT BELANJA AMAN DAN TERPERCAYA
                        </h3>
                        <p>Menyediakan berbagai kebutuhan anda baik yang ada maupun tidak ada
                            semuanya diada ada agar
                            menjadi ada. Agar semua puas, kamimenghadirkan dari berbagai suplier
                            yang tidak dapat dipercaya
                        </p>
                        <a class="white_bg_btn" href="#">lihat koleksi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Hot Deals Area =================-->
    <section class="hot_deals_area section_gap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hot_deal_box">
                        <img class="img-fluid" src="{{ asset('ecommerce/img/product/hot_deals/deal1.jpg') }}" alt="">
                        <div class="content">
                            <h2>PRODUK TERBARU</h2>
                            <p>belanja sekarang</p>
                        </div>
                        <a class="hot_deal_link" href="#"></a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hot_deal_box">
                        <img class="img-fluid" src="{{ asset('ecommerce/img/product/hot_deals/deal1.jpg') }}" alt="">
                        <div class="content">
                            <h2>PRODUK TERBARU</h2>
                            <p>belanja sekarang</p>
                        </div>
                        <a class="hot_deal_link" href="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Hot Deals Area =================-->

    <!--================Feature Product Area =================-->
    <section class="feature_product_area section_gap">
        <div class="main_box">
            <div class="container-fluid">
                <div class="row">
                    <div class="main_title">
                        <h2>Produk Terbaru</h2>
                        <p>Tampil trendi dengan kumpulan produk kekinian kami.</p>
                    </div>
                </div>
                <div class="row">
                    @forelse($products as $row)
                        <div class="col col1">
                            <div class="f_p_item">
                                <div class="f_p_img">
                                    <b style="color: white">{{ $row->image }}</b>
                                    <img src="{{ $row->image }}" width="100px" height="100px" alt="{{ $row->name }}">
                                    <div class="p_icon">
                                        <a href="{{ route('prodak', $row->id) }}">
                                            <i class="lnr lnr-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <a href="">
                                    <h4>{{ $row->name }}</h4>
                                </a>
                                <h5>Rp {{ number_format($row->price) }}</h5>
                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
                <div class="row">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
    <!--================End Feature Product Area =================-->
@endsection
