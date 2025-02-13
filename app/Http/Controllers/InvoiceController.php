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
        $invoice = Invoice::findOrFail($id);
        return view('invoice.show', compact('invoice'));
    }

    /**
     * Toon de create view voor een nieuwe factuur.
     */
    public function create()
    {
        $bookings = Booking::all();
        $lastInvoice = Invoice::latest('id')->first();
        $newNumber = $lastInvoice ? str_pad($lastInvoice->number + 1, 6, '0', STR_PAD_LEFT) : '000001';
       
        return view('invoice.create', [
            'bookings' => $bookings,
            'newNumber' => $newNumber,
        ]);
    }

    /**
     * Sla een nieuwe factuur op.
     */
    public function store(Request $request)
    {
        // Haal het laatste factuurnummer op
        $lastInvoice = Invoice::latest('id')->first();
        $newNumber = $lastInvoice ? str_pad($lastInvoice->number + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // Validate the request data
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id', // Ensure booking_id is provided and valid
            'number' => 'required|string', // Validate number field
            'date' => 'required|date',
            'amount_excl_vat' => 'required|numeric|min:0', // Validate amount fields
            'vat' => 'required|numeric|min:0',
            'amount_incl_vat' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:in behandeling,betaald,onbetaald',
            'note' => 'nullable|string', // Validate note field
        ]);

        // Add the generated invoice number to the validated data
        $validated['number'] = $newNumber;

        // dd($validated);

        // Create a new invoice
        Invoice::create($validated);

        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol aangemaakt.');
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
