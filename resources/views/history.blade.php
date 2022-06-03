@php
use App\Models\Product;
@endphp
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row mt-4 mb-2">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">History</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <td>No.</td>
                                <td>Tanggal Pesan</td>
                                <td>Gambar</td>
                                <td>Pesanan</td>
                                <td>Kategori</td>
                                <td>Jumlah Pesanan</td>
                                <td><strong>Total Harga</strong></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @forelse ($checkout_pesanan as $pesanan)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $pesanan->created_at }}</td>
                                    <td>
                                        @php
                                            $product = Product::where('id', $pesanan->product_id)->first();
                                        @endphp
                                        <img src="{{ url('assets/products') }}/{{ $product->gambar }}"
                                            class="img-fluid" width="50">
                                    </td>
                                    <td>

                                        <p>{{ $product->nama }}</p>
                                        <br>

                                    </td>
                                    <td>{{$product->kategori}}</td>
                                    <td>{{$pesanan->jumlah_pesanan}}</td>
                                    <td colspan="2"><strong>Rp.{{ number_format($pesanan->jumlah_pesanan*$product->harga+40000) }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Data Kosong</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
@endsection
