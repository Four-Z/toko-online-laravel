@extends('layouts.admin_navbar')
@section('content')
    <h2 class="d-flex justify-content-center mb-5">Rekap Laporan Beban {{ date('F') }}</h2>

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Keterangan</td>
                            <td><strong>Biaya</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <p style="color: black">listrik</p>
                                <br>
                            </td>
                            <td colspan="2">Rp.{{ number_format(900000) }}
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <p style="color: black">Paket Internet</p>
                                <br>
                            </td>
                            <td colspan="2">Rp.{{ number_format(300000) }}
                            </td>
                        </tr>
                        <td></td>
                        <td><b>Total</b> </td>
                        <td><b>Rp.{{ number_format(900000 + 300000) }}</b> </td>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
