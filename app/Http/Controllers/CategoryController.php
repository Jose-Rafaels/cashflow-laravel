<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categories = Category::paginate();

        return view('category.index', compact('categories'))
            ->with('i', ($request->input('page', 1) - 1) * $categories->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $category = new Category();

        return view('category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return Redirect::route('categories.index')
            ->with('success', 'Category created successfully.');
    }


    public function destroy($id): RedirectResponse
    {
        $category = Category::find($id);

        // Cek apakah kategori digunakan dalam transaksi
        if ($category->transactions()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete this category because it is used in transactions.');
        }

        // Hapus kategori jika tidak digunakan
        $category->delete();

        return Redirect::route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
