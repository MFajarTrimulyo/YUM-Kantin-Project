<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function menu(Request $request)
    {
        // --- MOCKUP DATA (Ganti ini dengan query Database Anda nanti) ---
        // Contoh DB: $products = Product::query();
        
        // Simulasi Pencarian
        $search = $request->input('search');
        $category = $request->input('category');

        // Data Dummy untuk Tampilan
        $products = collect([]);
        for ($i = 1; $i <= 12; $i++) {
            $products->push((object)[
                'id' => $i,
                'name' => 'Takoyaki Spesial Lezat ' . $i,
                'store_name' => 'Toko Toko',
                'category' => 'Makanan',
                'price' => 10000,
                'original_price' => 15000,
                'sold' => 100 + $i,
                'rating' => 4.5,
                'image' => 'pictures/example-food.png'
            ]);
        }

        // Jika menggunakan Database asli, gunakan ->paginate(12);
        // Disini kita pakai manual paginator untuk array dummy
        $perPage = 8;
        $page = request()->get('page', 1);
        $paginatedProducts = new LengthAwarePaginator(
            $products->forPage($page, $perPage),
            $products->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        if ($request->ajax()) {
            $view = view('user_page.menu.product-list', ['products' => $paginatedProducts])->render();
            return response()->json([
                'html' => $view,
                'next_page' => $paginatedProducts->nextPageUrl() ? $page + 1 : null
            ]);
        }

        return view('user_page.menu.index', [
            'products' => $paginatedProducts,
            'search' => $search,
            'currentCategory' => $category ?? 'Semua'
        ]);
    }
}
