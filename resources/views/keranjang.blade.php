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
                        <li class="breadcrumb-item active"><a href="{{ route('keranjang') }}">Keranjang</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <td>No.</td>
                                <td>Gambar</td>
                                <td>Keterangan</td>
                                <td>Jumlah</td>
                                <td>Harga</td>
                                <td>Ongkir</td>
                                <td><strong>Total Harga</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $total_harga = 0; ?>
                            @forelse ($pesanan_detail as $pesanan)

                                @php
                                    $product = Product::where('id', $pesanan->product_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <img src="{{ url('assets/products') }}/{{ $product->gambar }}"
                                            class="img-fluid" width="200">
                                    </td>
                                    <td>
                                        {{ $product->nama }}
                                    </td>
                                    <td>{{ $pesanan->jumlah_pesanan }}</td>
                                    <td>Rp. {{ number_format($product->harga) }}</td>
                                    <td>Rp. {{ number_format(40000) }}</td>
                                    <td><strong>Rp. {{ number_format($pesanan->jumlah_pesanan*$product->harga+40000) }}</strong></td>
                                    <td>
                                        <form action="/hapus-pesanan/{{$pesanan->id}}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $total_harga+=(($pesanan->jumlah_pesanan*$product->harga)+40000); ?>
                            @empty
                                <tr>
                                    <td colspan="7">Keranjang Kosong</td>
                                </tr>
                            @endforelse

                            @if (!empty($pesanan))
                        <tr>
                            <td colspan="6" align="right"><strong>Total Yang Harus dibayarkan : </strong></td>
                            <td align="right"><strong>Rp. {{ number_format($total_harga) }}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td colspan="2">
                                <a href="{{route('checkout.page')}}" class="btn btn-success btn-blok">
                                    <i class="fas fa-arrow-right"></i> Check Out
                                </a>
                            </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>

@endsection
