@extends('layouts.admin_navbar')
@php
use App\Models\Product;
use App\Models\User;
@endphp
@section('content')
    <h2 class="d-flex justify-content-center mb-5">Rekap Laporan Penjualan</h2>
    <section class="container ">
        <form action="{{ route('admin.laporan-penjualan-filtered') }}" method="POST">
            @csrf
            <div class="row form-group d-flex justify-content-center">
                <label for="date" class="col-sm-2 col-form-label">Mulai : </label>
                <div class="col-sm-4">
                    <div class="input-group date" id="datepicker">
                        <input type="text" class="form-control" name="start_date" value={{ $start }}>
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row form-group d-flex justify-content-center">
                <label for="date" class="col-sm-2 col-form-label">Hingga : </label>
                <div class="col-sm-4">
                    <div class="input-group date" id="datepicker2">
                        <input type="text" class="form-control" name="end_date" value={{ $end }}>
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <center>
                <button type="submit" name="tampilkan" class="btn btn-primary ">Tampilkan</button>
                <button type="submit" name="download" class="btn btn-primary">Download as PDF</button>
            </center>


        </form>
    </section>

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
                            <td>Pembeli</td>
                            <td><strong>Harga</strong></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php $total = 0; ?>
                        @forelse ($pesanan as $ps)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ps->created_at }}</td>
                                <td>
                                    @php
                                        $product = Product::where('id', $ps->product_id)->first();
                                    @endphp
                                    <img src="{{ url('assets/products') }}/{{ $product->gambar }}"
                                        class="img-fluid" width="50">
                                </td>
                                <td>

                                    <p>{{ $product->nama }}</p>
                                    <br>

                                </td>
                                <td>{{ $product->kategori }}</td>
                                <td>{{ $ps->jumlah_pesanan }}</td>

                                <td>
                                    @php
                                        $user = User::where('id', $ps->user_id)->first();

                                    @endphp
                                    {{ $user->name }}
                                </td>
                                <td colspan="2">Rp.{{ number_format($ps->jumlah_pesanan * $product->harga + 40000) }}
                                </td>
                                <?php $total += $ps->jumlah_pesanan * $product->harga + 40000; ?>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Data Kosong</td>
                            </tr>
                        @endforelse
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total</b> </td>
                        <td><b>Rp.{{ number_format($total) }}</b> </td>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
