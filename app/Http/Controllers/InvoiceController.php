<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;

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

        $lastInvoice = Invoice::latest('id')->first();
        $newNumber = $lastInvoice ? str_pad($lastInvoice->number + 1, 6, '0', STR_PAD_LEFT) : '000001';

       
        return view('invoice.create', compact('newNumber'));

    }

    /**
     * Sla een nieuwe factuur op.
     */
    public function store(Request $request)
    {
        // Haal het laatste factuurnummer op
        $lastInvoice = Invoice::latest('id')->first();
        $newNumber = $lastInvoice ? str_pad($lastInvoice->number + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // dd($request->all());

        $validated = $request->validate([
            
            // 'patient_id' => 'required|exists:patients,id',
            
            'date' => 'required|date',

            'status' => 'nullable|string|in:in behandeling,betaald,onbetaald',
        ]);


        // dd($request->all());

        
        $validated['number'] = $newNumber;

        // maak een nieuwe factuur aan
        Invoice::create($validated);

        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol aangemaakt.');
    }

    /**
     * Toon de edit view voor een bestaande factuur.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

       
        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Werk een bestaande factuur bij.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Valideer invoer
        $validated = $request->validate([
            // 'treatment_id' => 'required|exists:treatments,id',
           
            'number' => 'required|max:6',
            'date' => 'required|date',
            
            'status' => 'nullable|string|in:in behandeling,betaald,onbetaald',
        ]);

        // Update de factuur
        $invoice->update($validated);

        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol bijgewerkt.');
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
