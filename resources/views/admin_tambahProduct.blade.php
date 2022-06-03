@extends('layouts.admin_navbar')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-5 border">
            <div class="p-3 py-5">
                <div class="d-flex mb-3">
                    <a href="{{ route('admin.products') }}"><button type="button"
                            class="btn btn-outline-primary">Back</button></a>
                    <h4 class="text-left">&nbsp;Tambah Product</h4>
                </div>
                <form action="{{ route('admin.store_product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-12"><label class="labels">Nama</label><input type="text"
                                class="form-control" placeholder="nama product" name="nama" required /></div>
                        <div class="col-md-12"><label class="labels">Harga</label><input type="number"
                                class="form-control" placeholder="harga" name="harga" required /></div>
                        <div class="col-md-12"><label class="labels">Stock</label><input type="number"
                                class="form-control" placeholder="jumlah stock" name="stock" required></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Pilih Kategori</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="kategori" required>
                            <option>hoodie</option>
                            <option>crewneck</option>
                        </select>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Upload Foto</label>
                            <input type="file" class="form-control" placeholder="enter link foto" value="" name="foto"
                                required />
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button"
                            type="sumbit">Tambah</button>
                </form>
            </div>
        @endsection
