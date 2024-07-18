<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [''];
    use HasFactory;
    public function publisher()
    {
        return $this->belongsTo('App\Models\Publisher', 'publisher_id');
    }
    public function catalog()
    {
        return $this->belongsTo('App\Models\Catalog', 'catalog_id');
    }
    public function author()
    {
        return $this->belongsTo('App\Models\Author', 'author_id');
    }
    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, TransactionDetail::class, 'book_id', 'id', 'id', 'transaction_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
