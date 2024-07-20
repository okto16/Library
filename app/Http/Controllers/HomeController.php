<?php

namespace App\Http\Controllers;

use App\Helpers\LoanHelper;
use App\Models\Author;
use App\Models\Member;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Publisher;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $members = Member::with('user')->get();
        // $books = Book::with('publisher')->get();
        // $publisher = Publisher::with('books')->get();

        // return $publisher;

        // //no 1
        // $data1 = Member::select('*')->join('users', 'users.member_id', '=', 'members.id')->get();

        // //no 2
        // $data2 = Member::select('*')->leftJoin('users', 'users.member_id', '=', 'members.id')
        //     ->where('users.id', NULL)
        //     ->get();

        // //no 3
        // $data3 = Transaction::select('members.id', 'members.name')
        //     ->rightjoin('members', 'members.id', '=', 'transactions.member_id')
        //     ->where('transactions.member_id', NULL)
        //     ->get();
        // //no 4
        // $data4 = Member::select('members.id', 'members.name', 'members.phone_number')
        //     ->join('transactions', 'transactions.member_id', '=', 'members.id')
        //     ->orderBy('members.id', 'asc')
        //     ->get();
        // //no 5
        // $data5 = Member::select('members.id', 'members.name', 'members.phone_number')
        //     ->join('transactions', 'transactions.member_id', '=', 'members.id')
        //     ->groupBy('members.id', 'members.name', 'members.phone_number')
        //     ->havingRaw('COUNT(transactions.id) > 1')
        //     ->get();
        // //6
        // $data6 = Member::select('members.name', 'members.address', 'members.phone_number', 'date_start',  'date_end')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->get();
        // //7
        // $data7 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->whereRaw('MONTH(transactions.date_end) = 6')
        // ->get();
        // $data8 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->whereRaw('MONTH(transactions.date_end) = 5')
        // ->get();
        // $data9 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->whereRaw('MONTH(transactions.date_start) = 6')
        // ->whereRaw('MONTH(transactions.date_end) = 6')
        // ->get();
        // $data10 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->where('members.address', 'like', '%Bandung%')
        // ->get();
        // $data11 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->where('members.address', 'LIKE', '%Bandung%')
        // ->where('members.gender', 'LIKE', '%P%')
        // ->get();
        // $data12 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end', 'transaction_details.transaction_id', 'transaction_details.qty')
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
        // ->where('transaction_details.qty', '>', 1)
        // ->get();
        // $data13 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end', 'transaction_details.transaction_id', 'transaction_details.qty', 'books.title as judul_buku',
        // 'books.price',)
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
        // ->join('books', 'transaction_details.book_id', '=', 'books.id')
        // ->where('transaction_details.qty', '>', 1)
        // ->get();
        // $data14 = Member::select('members.name', 'members.phone_number', 'members.address', 'date_start',  'date_end', 'transaction_details.transaction_id', 'transaction_details.qty', 'books.title as judul_buku',
        // 'books.price',)
        // ->join('transactions', 'transactions.member_id', '=', 'members.id')
        // ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
        // ->join('books', 'transaction_details.book_id', '=', 'books.id')
        // ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
        // ->join('authors', 'books.author_id', '=', 'authors.id')
        // ->join('catalogs', 'books.catalog_id', '=', 'catalogs.id')
        // ->get();
        // $data15 = Catalog::select('catalogs.id', 'catalogs.name')
        // ->join('books', 'catalogs.id', '=', 'books.catalog_id')
        // ->get();
        // $data16 = Catalog::select('catalogs.id', 'catalogs.name', 'books.title as judul_buku')
        // ->join('books', 'catalogs.id', '=', 'books.catalog_id')
        // ->get();
        // $data17 = Author::select('*')
        // ->count();
        // $data18 = Book::select('*')
        // ->where('Books.price', '>', 10000)
        // ->get();
        // $data19 = Book::select('*')
        // ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
        // ->where('publishers.name', 'like', '%Penerbit 01%')
        // ->where('books.qty', '>', 10)
        // ->get();
        // $data20 = Member::select('*')
        // ->whereMonth('created_at', '=', '06')
        // ->get();    
        // return $data10;
        if (auth()->user()->hasRole('petugas')) {
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
}
