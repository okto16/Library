<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $transaction = TransactionDetail::with('book')->get();
     return $transaction;
         return view('admin.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         return view('admin.transaction.store');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionDetail $transactionDetail)
    {
         return view('admin.transaction.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionDetail $transactionDetail)
    {
         return view('admin.transaction.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionDetail $transactionDetail)
    {
         return view('admin.transaction.update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
         return view('admin.transaction.destroy');
    }
}
