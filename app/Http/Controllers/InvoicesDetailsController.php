<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachmentss;
use App\Models\Invoices;
use App\Models\invoices_details;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $invoices = Invoice::all();
        return view('invoices.details_invoices', compact('invoices'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $invoice = Invoice::with('attachment')->find($id);

        // return view('invoices.details_invoice',compact('invoice'));

        $invoices = Invoice::find($id);
        $details  = invoices_Details::where('id_Invoice', $id)->get();
        $attachments  = invoice_attachmentss::where('invoice_id', $id)->get();


        // if(DB::table('notifications')->where( 'read_at',null)->get()){
        //     $notificationid= DB::table('notifications')->find( 'notifiable_id');
        // }
        // $id = Auth::id();
        // $user = Auth::user()->name;

        // $user = User::find($name);

        // foreach ($user->unreadNotifications as $notification) {
        //     $notification->markAsRead();
        // }

        return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoice_attachmentss::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($invoice_number, $file_name)
    {
        $st = "Attachments";
        $pathToFile = public_path($st . '/' . $invoice_number . '/' . $file_name);
        return response()->download($pathToFile);
    }

    public function open_file($invoice_number, $file_name)
    {
        $st = "Attachments";
        $pathToFile = public_path($st . '/' . $invoice_number . '/' . $file_name);
        return response()->file($pathToFile);
    }
    public function MarkAsRead($invoiceId,$notificationid)
    {
        $invoice = Invoice::find($invoiceId);
        auth()->user()->unreadNotifications->where('id', $notificationid)->markAsRead();
        return view('invoices.details_invoice', compact('invoice'));
    }
}
