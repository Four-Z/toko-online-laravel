<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\VarDumper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'title' => config('app.name', 'Laravel'),
            'products' => Product::latest()->take(4)->get(),
            'kategori' => Kategori::all()
        ]);
    }


    public function list_all()
    {

        if (request('search')) {
            $product = Product::where('nama', 'like', '%' . request('search') . '%')->paginate(8);
        } else {
            $product = Product::paginate(8);
        }

        return view('list_product', [
            'title' => "All Products",
            'products' => $product,
        ]);
    }

    public function list_by_kategori($nama)
    {

        if (request('search')) {
            $product = Product::where('kategori', $nama)->where('nama', 'like', '%' . request('search') . '%')->paginate(8);
        } else {
            $product = Product::where('kategori', $nama)->paginate(8);
        }

        return view('list_product_byKategori', [
            'title' => ucwords($nama),
            'products' => $product,
            'kategori' => $nama
        ]);
    }

    public function product_detail($kategori, $id)
    {

        $product_detail = Product::find($id);
        return view('products_detail', [
            'title' => "Details",
            'product' => $product_detail,
            'kategori' => $kategori
        ]);
    }

    public function masuk_keranjang(Request $req)
    {

        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $product = Product::find($req->id);
        $jumlah_pesanan = $req->jumlah_pesanan;
        if ($jumlah_pesanan > $product->stock) {
            session()->flash('message_fail', 'Pembelian Gagal');

            return redirect()->back();
        }

        $total_harga = $jumlah_pesanan * $product->harga;

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('product_id', $product->id)->where('status', 0)->first();

        if (empty($pesanan)) {

            Pesanan::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'jumlah_pesanan' => $jumlah_pesanan,
                'status' => 0,
            ]);
            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
            $pesanan->update();
        } else {

            $pesanan->jumlah_pesanan += $jumlah_pesanan;
            $pesanan->update();
        }

        $product->stock -= $jumlah_pesanan;
        $product->update();

        session()->flash('message_success', 'Sukses Masuk Keranjang');
        return redirect()->back();
    }

    public function keranjang()
    {
        if (Auth::user()) {
            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->get();
            return view('keranjang', [
                'title' => "Keranjang",
                'pesanan_detail' => $pesanan,
            ]);
        } else {
            return redirect()->route('login');
        }
    }

    public function hapus_pesanan($id)
    {


        $pesanan = Pesanan::where('id', $id)->first();
        $product = Product::where('id', $pesanan->product_id)->first();

        $product->stock += $pesanan->jumlah_pesanan;
        $product->update();

        Pesanan::destroy($id);

        session()->flash('message', 'Pesanan Dihapus');
        return redirect()->back();
    }

    public function checkout_page()
    {
        $check_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        if (!Auth::user()) {
            return redirect()->route('login');
        }

        if (empty($check_pesanan)) {
            return redirect()->route('home');
        }

        $total_harga = 0;
        $all_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->get();
        foreach ($all_pesanan as $p) {
            $produk = Product::where('id', $p->product_id)->first();
            $total_harga += $p->jumlah_pesanan * $produk->harga;
        }

        $nohp = Auth::user()->nohp;
        $alamat = Auth::user()->alamat;

        return view('checkout', [
            'title' => "Checkout",
            'total_harga' => $total_harga,
            'nohp' => $nohp,
            'alamat' => $alamat
        ]);
    }

    public function checkout(Request $req)
    {

        $user = User::where('id', Auth::user()->id)->first();
        $user->nohp = $req->nohp;
        $user->alamat = $req->alamat;
        $user->update();

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->get();
        foreach ($pesanan as $p) {
            $p->status = 1;
            $p->update();
        }

        session()->flash('message', "Sukses Checkout");

        return redirect()->route('history');
    }

    public function history()
    {
        if (Auth::user()) {
            $chekout_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 1)->get();
        } else {
            return redirect()->route('login');
        }


        return view('history', [
            'title' => "History",
            'checkout_pesanan' => $chekout_pesanan
        ]);
    }

    public function admin()
    {

        $user = Auth::user();

        if ($user->isAdmin == 1) {
            return view('admin_home', [
                'title' => "Dashboard Admin",
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function show_statistic()
    {
        $user = Auth::user();

        if ($user->isAdmin == 1) {

            $all_pesanan = Pesanan::all()->where('status', 1);

            return view('admin_penjualan', [
                'title' => "Barang Terjual",
                'pesanan' => $all_pesanan
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function show_statistic_byDate(Request $request)
    {

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $get_pesanan_bydate = Pesanan::whereDate('created_at', '<=', $end)
            ->whereDate('created_at', '>=', $start)
            ->get();

        return view('admin_penjualan', [
            'title' => "Barang Terjual",
            'pesanan' => $get_pesanan_bydate
        ]);
    }

    public function admin_products()
    {
        $user = Auth::user();

        if ($user->isAdmin == 1) {
            $product = Product::all();
            return view('admin_products', [
                'title' => "Semua Products",
                'products' => $product
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function hapus_product($id)
    {
        Product::destroy($id);

        session()->flash('message', 'Product berhasil dihapus');
        return redirect()->back();
    }

    public function tambah_product_page()
    {
        $user = Auth::user();

        if ($user->isAdmin == 1) {
            return view('admin_tambahProduct', [
                'title' => "Tambah Product",
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function tambah_product(Request $req)
    {

        $this->validate($req, [
            'foto' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $foto = $req->file('foto');
        $random_name = Str::random(28);
        $foto->move(public_path('/assets/products'), $random_name);

        Product::create([
            'nama' => $req->nama,
            'harga' => $req->harga,
            'stock' => $req->stock,
            'kategori' => $req->kategori,
            'gambar' => $random_name

        ]);

        return redirect()->route('admin.products');
    }

    public function edit_product_page($id)
    {
        $user = Auth::user();

        if ($user->isAdmin == 1) {
            $product = Product::where('id', $id)->first();
            return view('admin_editProduct', [
                'title' => "Edit Product",
                'product' => $product
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function edit_product(Request $req)
    {
        $product = Product::where('id', $req->id)->first();
        if ($req->hasFile('foto')) {
            $this->validate($req, [
                'foto' => 'required|image|mimes:jpeg,png,jpg'
            ]);

            $foto = $req->file('foto');
            $random_name = Str::random(28);
            $foto->move(public_path('/assets/products'), $random_name);
            $product->gambar = $random_name;
        }

        $product->nama = $req->nama;
        $product->harga = $req->harga;
        $product->stock = $req->stock;
        $product->kategori = $req->kategori;
        $product->update();

        return redirect()->route('admin.products');
    }


    public function generatePDF()
    {
        $all_pesanan = Pesanan::all()->where('status', 1);

        $pdf = Pdf::loadview('myPDF', ['pesanan' => $all_pesanan]);
        return $pdf->download('laporan-hasil-penjualan.pdf');
    }

    public function laporan_penjualan()
    {
        $user = Auth::user();

        if ($user->isAdmin == 1) {

            return view('admin_laporan_penjualan', [
                'title' => "Laporan Penjualan",
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function laporan_penjualan_filtered(Request $request)
    {
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $get_pesanan_bydate = Pesanan::whereDate('created_at', '<=', $end)
            ->whereDate('created_at', '>=', $start)->where('status', 1)
            ->get();

        if (isset($_POST['tampilkan'])) {
            return view('admin_laporan_penjualan_filtered', [
                'title' => "Laporan penjualan ",
                'pesanan' => $get_pesanan_bydate,
                'start' => $start,
                'end' => $end
            ]);
        } elseif (isset($_POST['download'])) {
            $pdf = Pdf::loadview('myPDF', ['pesanan' => $get_pesanan_bydate]);
            return $pdf->download('laporan-hasil-penjualan.pdf');
        }
    }

    public function laporan_beban()
    {
        return view('admin_laporanBeban', [
            'title' => "Laporan Beban"
        ]);
    }

    public function laporan_laba()
    {
        $timestamp    = strtotime(date('M Y'));
        $start = date('01-m-Y 00:00:00', $timestamp);
        $end  = date('t-m-Y 12:59:59', $timestamp);

        $start = Carbon::parse($start);
        $end  = Carbon::parse($end);

        $get_pesanan_bydate = Pesanan::whereDate('created_at', '<=', $end)
            ->whereDate('created_at', '>=', $start)->where('status', 1)
            ->get();

        $total = 0;
        foreach ($get_pesanan_bydate as $p) {
            $product = Product::where('id', $p->product_id)->first();
            $total += $p->jumlah_pesanan * $product->harga + 40000;
        }

        return view('admin_laporanLaba', [
            'title' => "Laporan Laba",
            'pesanan' => $get_pesanan_bydate,
            'total' => $total,
            'bulan' => date('F'),
            'tahun' => date('Y')
        ]);
    }

    public function laporan_laba_filtered(Request $req)
    {
        $bulan = $req->bulan;
        $tahun = $req->tahun;

        $date_start =  Carbon::parse("{$tahun}/{$bulan}/01");
        $date_end = Carbon::parse(date("Y-m-t", strtotime($date_start)));

        $get_pesanan_bydate = Pesanan::whereDate('created_at', '<=', $date_end)
            ->whereDate('created_at', '>=', $date_start)->where('status', 1)
            ->get();


        $total = 0;
        foreach ($get_pesanan_bydate as $p) {
            $product = Product::where('id', $p->product_id)->first();
            $total += $p->jumlah_pesanan * $product->harga + 40000;
        }

        $timestamp = strtotime("{$tahun}/{$bulan}/01");
        return view('admin_laporanLaba', [
            'title' => "Laporan Laba",
            'pesanan' => $get_pesanan_bydate,
            'total' => $total,
            'bulan' => date("M", $timestamp),
            'tahun' => date("Y", $timestamp)
        ]);
    }

}
