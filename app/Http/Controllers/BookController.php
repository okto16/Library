<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('petugas')){
            $publishers = Publisher::all();
            $authors = Author::all();
            $catalogs = Catalog::all();
            return view('admin.book.index', compact('publishers', 'authors', 'catalogs'));
        }else{
            return abort(403);
        }
    }
    public function api()
    {
        $books = Book::all();
        return json_encode($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'isbn'=>['required'],
            'title'=>['required'],
            'year'=>['required'],
            'publisher_id'=>['required'],
            'author_id'=>['required'],
            'catalog_id'=>['required'],
            'qty'=>['required'],
            'price'=>['required'],
        ]);
        Book::create($request->all());
        return redirect('books');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('admin.book.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('admin.book.edit',compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $this->validate($request, [
            'isbn'=>['required'],
            'title'=>['required'],
            'year'=>['required'],
            'publisher_id'=>['required'],
            'author_id'=>['required'],
            'catalog_id'=>['required'],
            'qty'=>['required'],
            'price'=>['required'],
        ]);
        $book->update($request->all());
        return redirect('books');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('books');
    }
}
