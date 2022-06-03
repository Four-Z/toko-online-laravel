@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="banner">
            <img src="{{ url('assets/sliders/slider1.png') }}" alt="">
        </div>

        {{-- PILIH HARDWARE --}}
        <section class="pilih-hardware mt-4">
            <h3><strong>Pilih Kategori</strong></h3>
            <div class="row mt-4">
                @foreach ($kategori as $ktg)
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <a href="/products/{{ $ktg->nama }}">
                                    <img src="{{ url('assets/kategori') }}/{{ $ktg->gambar }}" class="img-fluid">
                                </a>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- LATEST PRODUCT --}}
        <section class="products mt-5 mb-5">
            <h3>
                <strong>Produk Terbaru</strong>
                <a href="{{ route('products') }}" class="btn btn-dark float-right"><i class="fas fa-eye"></i> Lihat
                    Semua </a>
            </h3>
            <div class="row mt-4">
                @foreach ($products as $product)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="{{ url('assets/products') }}/{{ $product->gambar }}" class="img-fluid">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h5><strong>{{ $product->nama }}</strong> </h5>
                                        <h5>Rp. {{ number_format($product->harga) }}</h5>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <a href="{{ route('product.detail', [$product->kategori, $product->id]) }}"
                                            class="btn btn-dark btn-block"><i class="fas fa-eye"></i> Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        @include('layouts.footer')
    </div>
@endsection
