@extends('layouts.admin_navbar')
@php
use App\Models\Product;
use App\Models\User;
// $total = 0;

// foreach ($pesanan as $p) {
//     $product = Product::where('id', $p->product_id)->first();
//     $total = $p->jumlah_pesanan * $product->harga + 40000;
// }
@endphp
@section('content')
    <div>
        <form action="{{ route('admin.laporan-laba-filtered') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-2 ">
                <label for="exampleFormControlSelect1 ">Pilih Bulan</label>
                <select class="form-control" id="exampleFormControlSelect1" name="bulan" required>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <div class="mt-2">
                    <label class="labels">Tahun</label>
                    <input type="text" class="form-control" placeholder="contoh 2022" name="tahun" required />
                </div>
            </div>
            <div class="mt-2 ml-3 text-left"><button class="btn btn-primary profile-button" type="sumbit">filtered</button>
        </form>
    </div>

    <h2 class="d-flex justify-content-center mb-5">Rekap Laporan Laba {{ $bulan }} {{ $tahun }}</h2>

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Keterangan</td>
                            <td><strong>Total</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <p style="color: black">Penjualan Bulan {{ $bulan }} {{ $tahun }}</p>
                                <br>
                            </td>
                            <td colspan="2">Rp.{{ number_format($total) }}
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <p style="color: black">Biaya Beban</p>
                                <br>
                            </td>
                            <td colspan="2">Rp.{{ number_format(1200000) }}
                            </td>
                        </tr>
                        <td></td>
                        <td><b>Laba/Rugi</b> </td>
                        <td><b>Rp.{{ number_format($total - 1200000) }}</b> </td>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
