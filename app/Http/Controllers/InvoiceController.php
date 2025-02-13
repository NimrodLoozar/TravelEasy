<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class InvoiceController extends Controller
{
    /**
     * Toon de lijst met facturen.
     */
    public function index()
    {
        $invoices = Invoice::with(['booking.customer.person'])->orderBy('id', 'desc')->paginate(12);
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Toon details van een specifieke factuur.
     */
    public function show($id)
    {
        $invoice = Invoice::with([
            'booking.customer.person',
            'booking.trip'
        ])->findOrFail($id);

        return view('invoice.show', compact('invoice'));
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

        $booking = Booking::with(['customer.person', 'trip'])->findOrFail($request->booking_id);

        // Bereken bedragen
        $vat = $request->amount_excl_vat * 0.21;
        $total = $request->amount_excl_vat + $vat;

        // Genereer een factuur
        $invoice = Invoice::create([
            'number'          => Invoice::latest()->first()->number + 1 ?? 1001,
            'date'            => now()->toDateString(),
            'status'          => $request->status,
            'amount_excl_vat' => $request->amount_excl_vat,
            'vat'             => $vat,
            'amount_incl_vat' => $total,
            'note'            => $request->note,
            'booking_id'      => $booking->id,
        ]);

        return redirect()->route('invoice.show', $invoice->id)
            ->with('success', 'Factuur succesvol aangemaakt.');
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
    
        // Bereken bedragen
        $vat = $request->amount_excl_vat * 0.21;
        $total = $request->amount_excl_vat + $vat;
    
        // Update factuur
        $invoice->update([
            'date'            => $request->date,
            'status'          => $request->status,
            'amount_excl_vat' => $request->amount_excl_vat,
            'vat'             => $vat,
            'amount_incl_vat' => $total,
            'note'            => $request->note,
        ]);
    
        return redirect()->route('invoice.show', $invoice->id)
            ->with('success', 'Factuur succesvol bijgewerkt.');
    }

    /**
     * Verwijder een factuur.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

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
