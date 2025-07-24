<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function exportPDF()
    {
        $orders = \App\Models\Order::all();
        $pdf = Pdf::loadView('admin.exports.orders_pdf', compact('orders'));
        return $pdf->download('orders.pdf');
    }
}
