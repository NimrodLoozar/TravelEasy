<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Toon de lijst met facturen.
     */
    public function index()
    {
        $invoices = DB::select('CALL spGetAllInvoices()');
        log::info('Fetched all invoices', ['count' => count($invoices)]);
        return view('invoice.index', compact('invoices'));
    }
    

    /**
     * Toon details van een specifieke factuur.
     */
    public function show($id)
    {
        $invoice = DB::select('CALL spGetInvoiceById(?)', [$id]);
        \Illuminate\Support\Facades\Log::info('Fetched invoice by ID', ['id' => $id, 'found' => !empty($invoice)]);
    
        if (empty($invoice)) {
            abort(404, 'Factuur niet gevonden');
        }
    
        return view('invoice.show', ['invoice' => $invoice[0]]);
    }
    

    /**
     * Toon de create view voor een nieuwe factuur.
     */
    public function create()
    {
        $bookings = Booking::with(['customer.person', 'trip'])->get();

        // Bepaal het volgende factuurnummer
        $latestInvoice = Invoice::latest()->first();
        $newNumber = $latestInvoice ? $latestInvoice->number + 1 : 1001;

        return view('invoice.create', compact('bookings', 'newNumber'));
    }
    /**
     * Sla een nieuwe factuur op.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'      => 'required|exists:bookings,id',
            'status'          => 'required|in:in behandeling,betaald,onbetaald',
            'amount_excl_vat' => 'required|numeric|min:0',
            'note'            => 'nullable|string|max:500',
        ]);
    
        $vat = $request->amount_excl_vat * 0.21;
        $total = $request->amount_excl_vat + $vat;
        $newNumber = Invoice::latest()->first()->number + 1 ?? 1001;
    
        DB::statement('CALL spAddInvoice(?, ?, ?, ?, ?, ?, ?, ?)', [
            $newNumber, now()->toDateString(), $request->status, 
            $request->amount_excl_vat, $vat, $total, 
            $request->note, $request->booking_id
        ]);
    
        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol aangemaakt.');
    }
    

    /**
     * Toon de edit view voor een bestaande factuur.
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice.edit', compact('invoice'));
    }
    
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'date'            => 'required|date',
            'status'          => 'required|in:in behandeling,betaald,onbetaald',
            'amount_excl_vat' => 'required|numeric|min:0',
            'note'            => 'nullable|string|max:500',
        ]);
    
        $vat = $request->amount_excl_vat * 0.21;
        $total = $request->amount_excl_vat + $vat;
    
        DB::statement('CALL spUpdateInvoice(?, ?, ?, ?, ?, ?, ?)', [
            $invoice->id, $request->date, $request->status, 
            $request->amount_excl_vat, $vat, $total, $request->note
        ]);
    
        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol bijgewerkt.');
    }
    

    /**
     * Verwijder een factuur.
     */
    public function destroy($id)
    {
        DB::statement('CALL spDeleteInvoice(?)', [$id]);
    
        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol verwijderd.');
    }
    

    /**
     * Genereer het volgende factuurnummer.
     */
    public function latestNumber()
    {
        $latestInvoice = Invoice::orderBy('number', 'desc')->first();
        $nextNumber = $latestInvoice ? intval($latestInvoice->number) + 1 : 1;

        return response()->json(['nextNumber' => str_pad($nextNumber, 6, '0', STR_PAD_LEFT)]);
    }
}
