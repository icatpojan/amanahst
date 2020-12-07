@extends('layouts.ecommerce')

@section('title')
    <title>SI AMANAH</title>
@endsection

@section('content')
    <!--================Feature Product Area =================-->
    <section class="feature_product_area section_gap">
        <div class="main_box">
            <div class="container-fluid">
                <div class="row">
                    <div class="main_title mt-5">
                        <h2>Produk Terbaru</h2>
                        <p>Tampil trendi dengan kumpulan produk kekinian kami.</p>
                    </div>
                </div>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="{{ $product->image }}" alt="barang ilegal" width="150px" height="200px">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h1 class="card-title" style="color: black">{{ $product->name }}</h1>
                                <p class="card-text">{{ $product->description }}</p>
                                <h2 class="card-text"><small
                                        class="text-muted">Rp.{{ number_format($product->price) }}</small>
                                </h2>
                                <label for="vol">Jumlah pesan</label>
                                <input type="range" min="0" max="{{ $product->stock }}" value="1" id="vol"
                                    oninput="nilai(value)">
                                <output for="vol" id="volume">50</output>

                                <script>
                                    function nilai(vol) {
                                        document.querySelector('#volume').value = vol;
                                    }

                                </script>


                                <div class="product_count">
                                    <label for="qty">Quantity:</label>
                                    <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                        class="input-text qty">

                                    <!-- BUAT INPUTAN HIDDEN YANG BERISI ID PRODUK -->
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" class="form-control">

                                    <button
                                        onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                        class="increase items-count" type="button">
                                        <i class="lnr lnr-chevron-up"></i>
                                    </button>
                                    <button
                                        onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                        class="reduced items-count" type="button">
                                        <i class="lnr lnr-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!--================End Feature Product Area =================-->
@endsection
