@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row mt-4 mb-2">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('products') }}" class="text-dark">All Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="/products/{{$kategori}}" class="text-dark">{{ucwords($kategori)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message_success'))
                    <div class="alert alert-success">
                        {{ session('message_success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message_fail'))
                    <div class="alert alert-danger">
                        {{ session('message_fail') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card gambar-product">
                    <div class="card-body">
                        <img src="{{ url('assets/products') }}/{{ $product->gambar }}" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>
                    <strong>{{ $product->nama }}</strong>
                </h2>
                <h4>
                    Rp. {{ number_format($product->harga) }}
                    @if ($product->stock >= 1)
                        <span class="badge badge-success"> <i class="fas fa-check"></i> Ready Stok</span>
                    @else
                        <span class="badge badge-danger"> <i class="fas fa-times"></i> Stok Habis</span>
                    @endif
                </h4>
                <div class="row">
                    <div class="col">
                        <form action="{{ route('masuk.keranjang') }}" method='POST'>
                            @csrf
                            <table class="table" style="border-top : hidden">
                                <tr>
                                    <td>Stock</td>
                                    <td>:</td>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah</td>
                                    <td>:</td>
                                    <td>
                                        <input name='jumlah_pesanan' id="jumlah_pesanan" type="number"
                                            class="form-control @error('jumlah_pesanan') is-invalid @enderror"
                                            value="{{ old('jumlah_pesanan') }}" required autocomplete="name" autofocus>

                                        @error('jumlah_pesanan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr hidden>
                                    <input type="text" name='id' value="{{ $product->id }}" hidden>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <button type="submit" class="btn btn-dark btn-block" @if ($product->stock <= 0) disabled @endif><i
                                                class="fas fa-shopping-cart"></i> Masukkan Keranjang</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @include('layouts.footer')
    </div>

@endsection
