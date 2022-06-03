@extends('layouts.admin_navbar')
@section('content')
    <h2 class="d-flex justify-content-center mb-5">Rekap Laporan Penjualan</h2>
    <section class="container ">
        <form action="{{ route('admin.laporan-penjualan-filtered') }}" method="POST">
            @csrf
            <div class="row form-group d-flex justify-content-center">
                <label for="date" class="col-sm-2 col-form-label">Mulai : </label>
                <div class="col-sm-4">
                    <div class="input-group date" id="datepicker">
                        <input type="text" class="form-control" name="start_date">
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
                        <input type="text" class="form-control" name="end_date">
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
            </center>

        </form>
    </section>

    <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker();
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('#datepicker2').datepicker();
        });
    </script>
@endsection
