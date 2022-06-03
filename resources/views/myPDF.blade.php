@php
use App\Models\Product;
use App\Models\User;
@endphp

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal Pesan</td>
                            <td>Pesanan</td>
                            <td>Jumlah Pesanan</td>
                            <td>Pembeli</td>
                            <td><strong>Harga</strong></td>
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
                                    <p>{{ $product->nama }}</p>
                                    <br>

                                </td>
                                <td>{{ $ps->jumlah_pesanan }}</td>

                                <td>
                                    @php
                                        $user = User::where('id', $ps->user_id)->first();

                                    @endphp
                                    {{ $user->name }}
                                </td>
                                <td colspan="2">
                                    <strong>Rp.{{ number_format($ps->jumlah_pesanan * $product->harga + 40000) }}</strong>
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
                        <td>Total</td>
                        <td>Rp.{{ $total }}</td>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>
