<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('pos.index', compact('menus'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('menus', 'public');
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'foto'      => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function checkout(Request $request)
    {
        $cart = json_decode($request->cart_data, true);
        if (!$cart || count($cart) === 0) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            
            // Potong stok
            $menu = Menu::find($item['id']);
            if ($menu) {
                $menu->stok = max(0, $menu->stok - $item['qty']);
                $menu->save();
            }
        }

        $uangBayar = $request->metode_bayar === 'cash' ? (int)$request->uang_bayar : $totalHarga;
        $kembalian = max(0, $uangBayar - $totalHarga);

        Order::create([
            'kode_transaksi' => 'TRX-' . time(),
            'items'          => $cart,
            'total_harga'    => $totalHarga,
            'metode_bayar'   => $request->metode_bayar,
            'uang_bayar'     => $uangBayar,
            'kembalian'      => $kembalian,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan!');
    }
}