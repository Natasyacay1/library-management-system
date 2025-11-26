<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category', 'reviews');
        
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->byCategory($request->category);
        }
        
        $books = $query->withCount('loans')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
        
        $categories = Category::all();
        
        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'nullable|string|unique:books',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'max_loan_days' => 'required|integer|min:1|max:30',
            'fine_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('book-covers', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['available_stock'] = $validated['stock'];
        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user', 'loans.user']);
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1|max:30',
            'fine_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image_path) {
                Storage::disk('public')->delete($book->image_path);
            }
            
            $imagePath = $request->file('image')->store('book-covers', 'public');
            $validated['image_path'] = $imagePath;
        }

        $book->updateStock($validated['stock']);
        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->where('status', 'borrowed')->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam.');
        }

        if ($book->image_path) {
            Storage::disk('public')->delete($book->image_path);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}