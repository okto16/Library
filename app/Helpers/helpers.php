<?php

use App\Models\Transaction;
use Carbon\Carbon;

function convert_date($value){
    return date('H:i:s - d/m/Y', strtotime($value));
}
function isTransactionLate($date_end)
{
    return (strtotime($date_end) < strtotime(today())) ? true : false;
}

if (!function_exists('getLateLoans')) {
    function getLateTransactions() {
        $today = Carbon::today();
        return Transaction::where('date_end', '<', $today)
                    ->where('status', '!=', '1')
                    ->get();
    }
}
?>