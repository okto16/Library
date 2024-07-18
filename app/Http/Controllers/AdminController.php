<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{

    public function dashboard()
    {
        if (auth()->user()->hasRole('petugas')){
            $total_buku = Book::count();
            $total_member = Member::count();
            $total_penerbit = Publisher::count();
            $total_peminjaman = Transaction::count();
    
            $donut = Book::select(DB::raw("COUNT(publisher_id) as count"))->groupBy("publisher_id")->orderBy('publisher_id', 'asc')->pluck('count');
            $label_donut = Publisher::orderBy('publisher_id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->groupBy('publishers.name')->pluck('publishers.name');
    
            $label_bar = ['Peminjaman', 'Pengembalian'];
            $data_bar = [];
            foreach ($label_bar as $key => $value) {
                $data_bar[$key]['label'] = $label_bar[$key];
                $data_bar[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,188,0.9)' : 'rgba(210,214,222,1)';
                $data_month = [];
                foreach (range(1, 12) as $month) {
                    if ($key == 0) {
                        $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', '=', $month)->first()->total;
                    }
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_end', '=', $month)->first()->total;
                }
                $data_bar[$key]['data'] = $data_month;
            }
            return view('home', compact('total_buku', 'total_member', 'total_penerbit', 'total_peminjaman', 'donut', 'label_donut', 'data_bar'));
        } else {
            return abort(403);
        }
    }

    public function catalogs()
    {
        if (auth()->user()->hasRole('petugass')){
            $catalogs = Catalog::all();
            return view('admin.catalog.index', compact('catalogs'));
        } else{
            return abort(403);
        }
    }

    public function books()
    {
        if (auth()->user()->hasRole('petugas')) {          
            $publishers = Publisher::all();
            $authors = Author::all();
            $catalogs = Catalog::all();
            $books = Book::all();
            return view('admin.book.index', compact('books', 'publishers', 'authors', 'catalogs'));
        }else{
            return abort(403);
        }
    }

    public function authors()
    {
        if (auth()->user()->hasRole('petugas')){
            $authors = Author::all();
            return view('admin.author.index', compact('authors'));
        } else {
            return abort(403);
        }
    }

    public function members()
    {
        if (auth()->user()->hasRole('petugas')) {
            $member = Member::all();
            return view('admin.member.index', compact('member'));
        } else {
            return abort(403);
        }
    }

    public function publishers()
    {   
        if (auth()->user()->hasRole('petugas')){
            $publisher = Publisher::all();
            return view('admin.Publisher.index', compact('publisher'));
        } else {
            return abort(403);
        }
    }

    public function transactions()
    {
        if (auth()->user()->hasRole('petugas')) {
            $members = Member::all();
            $books = Book::all();
            $transactions = Transaction::all();
            return view('admin.transaction.index', compact('transactions', 'members', 'books'));
        } else {
            return abort(403);
        }
    }

    public function test_spatie()
    {
        // $role = Role::create(['name' => 'petugas']);
        // $permission = Permission::create(['name' => 'index transactions']);

        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // $user = auth()->user();
        // $user->assignRole('petugas');
        // return $user; // Pastikan roles sudah terisi


        $user = User::with('roles')->get();
        return $user;

        // $user =  auth()->user();
        // $user->removeRole('petugas');
    }
}
