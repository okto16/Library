<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class Transactioncontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->status) {
                $datas = Transaction::where('status', $request->status)->get();
            } elseif ($request->date_start) {
                $datas = Transaction::where('date_start', $request->date_start)->get();
            } else {
                $datas = Transaction::all();
            }

            $datatables = datatables()->of($datas)->addIndexColumn();
            return $datatables->make(true);
        }
        $members = Member::all();
        $books = Book::all();
        // $lateTransactions = Transaction::where('status', false)
        // ->whereDate('date_end', '<', now())
        // ->get();
        // $lateTransactionsCount = $lateTransactions->count();
        return view('admin.transaction.index', compact('members', 'books'));
    }

    public function api()
{
    $transaction = Transaction::with('books')->get(); // Include books relation
    $datatables = datatables()->of($transaction)
        ->addColumn('date', function ($transaction) {
            return convert_date($transaction->date_start);
        })->addIndexColumn();

    return $datatables->make(true);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'books' => 'required|array',
            'books.*' => 'required|exists:books,id',
        ]);

        // Hitung total buku yang dipinjam
        $total_buku = count($request->books);

        // Buat transaksi
        $transaction = Transaction::create([
            'member_id' => $request->member_id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'status' => 0, // default status
            'total_buku' => $total_buku,
            'total_bayar' => $total_buku,
        ]);

        // Simpan detail transaksi
        foreach ($request->books as $book_id) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'book_id' => $book_id,
                'qty' => 1, // asumsikan qty 1 untuk setiap buku
            ]);
            // Kurangi qty buku yang dipinjam
            $book = Book::find($book_id);
            $book->qty -= 1; // Kurangi qty buku yang dipinjam
            $book->save();
        }

        // Hitung dan simpan total bayar
        $transaction->total_bayar = $transaction->calculateTotalBayar();
        $transaction->save();

        return redirect('transactions');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactiondetail.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return view('admin.transactiondetail.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'member_id' => 'required|exists:members,id',
        'date_start' => 'required|date',
        'date_end' => 'required|date',
        'books' => 'required',
        'books.*' => 'required|exists:books,id',
    ]);

    // Dapatkan transaksi berdasarkan ID
    $transaction = Transaction::findOrFail($id);

    // Update data transaksi
    $transaction->member_id = $request->member_id;
    $transaction->date_start = $request->date_start;
    $transaction->date_end = $request->date_end;
    $transaction->status = $request->status;
    $transaction->total_buku = count($request->books);
    
    // Simpan transaksi
    $transaction->save();

    // Hapus detail transaksi yang lama
    $transaction->details()->delete();

    // Simpan detail transaksi yang baru
    foreach ($request->books as $book_id) {
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'book_id' => $book_id,
            'qty' => 1, // Asumsikan qty 1 untuk setiap buku
        ]);

        // Kurangi qty buku yang dipinjam
        $book = Book::find($book_id);
        $book->qty -= 1;
        $book->save();
    }

    // Hitung dan simpan total bayar
    $transaction->save();

    return redirect('transactions')->with('success', 'Transaction updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
                $transaction->delete();
        return redirect('transactions');
    }
}
