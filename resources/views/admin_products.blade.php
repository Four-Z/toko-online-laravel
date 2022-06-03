@extends('layouts.admin_navbar')

@section('content')
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
                            <td>Gambar</td>
                            <td>Nama</td>
                            <td>Kategori</td>
                            <td>Harga</td>
                            <td>Stock</td>
                            <td>Ket</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php $total = 0; ?>
                        @forelse ($products as $pd)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <img src="{{ url('assets/products') }}/{{ $pd->gambar }}" class="img-fluid"
                                        width="50">
                                </td>
                                <td>
                                    <p>{{ $pd->nama }}</p>
                                    <br>
                                </td>
                                <td>{{ $pd->kategori }}</td>
                                <td>Rp. {{ number_format($pd->harga) }}</td>
                                <td>{{ $pd->stock }}</td>
                                <td>
                                    <form action="{{ route('admin.hapusProduct', $pd->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.edit_product', $pd->id) }}" method="GET"
                                        class="mt-2">
                                        @csrf
                                        <button onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-edit text-primary"></i>
                                        </button>
                                    </form>
                                </td>



                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Data Kosong</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <a href="{{ route('admin.tambah_product') }}" class="btn btn-primary">Tambah Product</a>
            </div>
        </div>
    </div>
@endsection
