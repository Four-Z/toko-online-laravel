@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4 mb-2">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('keranjang') }}" class="text-dark">Keranjang</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Check Out</li>
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
                <a href="{{ route('keranjang') }}" class="btn btn-sm btn-dark"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <h4>Informasi Pembayaran</h4>
                <hr>
                <p>Untuk pembayaran silahkan dapat transfer di rekening dibawah ini sebesar : </p>
                <p>Harga Barang : <strong> Rp.{{ number_format($total_harga) }}</strong>, Harga Ongkir : <strong> Rp.{{ number_format(40000) }}</strong></p>
                <p>Total Harga  : <strong> Rp.{{ number_format($total_harga+40000) }}</strong></p>
                <div class="media">
                    <img class="mr-3" src="{{ url('assets/bri.png') }}" alt="Bank BRI" width="60">
                    <div class="media-body">
                        <h5 class="mt-0">BANK BRI</h5>
                        No. Rekening 012345-678-910 atas nama <strong>Nanda</strong>
                    </div>
                </div>
            </div>
            <div class="col">
                <h4>Informasi Pengiriman</h4>
                <hr>
                <form action="/checkout" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">No. HP</label>
                        <input id="nohp" type="number" class="form-control " value="{{ $nohp }}"
                            autocomplete="name" name="nohp" autofocus required>
                    </div>

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea type="text" class="form-control" required name="alamat">{{ $alamat }}</textarea>

                    </div>

                    <button type="submit" class="btn btn-success btn-block"> <i class="fas fa-arrow-right"></i> Checkout
                    </button>
                </form>
            </div>
        </div>
        @include('layouts.footer')
    </div>
@endsection
