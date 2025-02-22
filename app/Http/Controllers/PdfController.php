<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function __invoke(Order $order)
    {
        $pdf = PDF::loadView('pdf.order-pdf', compact('order'));
        return $pdf->download('order.pdf');
    }
}
