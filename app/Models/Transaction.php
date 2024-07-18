<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{   
    protected $casts = [
        'due_date' => 'datetime',
    ];
    protected $guarded = [''];
    use HasFactory;
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function member()
    {
        return $this->belongsTo('App\Models\Transaction', 'member_id');
    }
    public function books()
    {
        return $this->hasManyThrough(Book::class, TransactionDetail::class, 'transaction_id', 'id', 'id', 'book_id');
    }
    public function getLamaPinjamAttribute()
    {
        return Carbon::parse($this->date_start)->diffInDays(Carbon::parse($this->date_end));
    }

    public function calculateTotalBayar()
    {
        return $this->books->sum('price');
    }
    public function calculateTotalBuku()
    {
        return $this->books->sum('book_id');
    }
}
