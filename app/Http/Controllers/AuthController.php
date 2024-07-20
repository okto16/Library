<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthController extends Controller
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

        return view('admin.author.index');
    }

    public function api()
    {
        if (auth()->user()->hasRole('petugas')) {
            $authors = Author::all();
            $datatables = datatables()->of($authors)
                ->addColumn('date', function ($author) {
                    return convert_date($author->created_at);
                })->addIndexColumn();
            return $datatables->make(true);
        } else {
            return abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.author.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
            'address' => ['required'],
        ]);
        Author::create($request->all());
        return redirect('authors');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('admin.author.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('admin.author.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $this->validate($request, [
            'name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
            'address' => ['required'],
        ]);
        $author->update($request->all());
        return redirect('authors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect('authors');
    }
}
