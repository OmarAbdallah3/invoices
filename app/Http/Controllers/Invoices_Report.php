<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Invoices_Report extends Controller
{
    public function index()
    {

        return view('reports.invoices_report');
    }

    public function Search_invoices(Request $request)
    {
        

        $rdio = $request->rdio;


        // في حالة البحث بنوع الفاتورة

        if ($rdio == 1) {


            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at == '' && $request->end_at == '') {

                $invoices = invoice::select('*')->where('status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type','invoices'));
            }

            // في حالة تحديد تاريخ استحقاق
            else {

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                

                $invoices = invoice::whereBetween('invoice_date', [$start_at, $end_at])->where('status', '=', $request->type)->get();
                
                return view('reports.invoices_report', compact('type', 'start_at', 'end_at','invoices'));
            }
        }

        //====================================================================

        // في البحث برقم الفاتورة
        else {

            $invoices = invoice::select('*')->where('invoice_number', '=', $request->invoice_number)->get();
            return view('reports.invoices_report',compact('invoices'));
        }
    }
}
