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
    public function edit($id)
    {
        // Haal de factuur op die bewerkt moet worden
        $invoice = Invoice::findOrFail($id);

        // Haal alle bookings op (of een gefilterde lijst, afhankelijk van je behoeften)
        $bookings = Booking::all();

        // Geef de factuur en bookings door aan de view
        return view('invoice.edit', compact('invoice', 'bookings'));
    }

    /**
     * Werk een bestaande factuur bij.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'amount_excl_vat' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'amount_incl_vat' => 'required|numeric|min:0',
            'status' => 'required|in:in behandeling,betaald,onbetaald',
            'booking_id' => 'required|exists:bookings,id',
            'note' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol bijgewerkt!');
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
