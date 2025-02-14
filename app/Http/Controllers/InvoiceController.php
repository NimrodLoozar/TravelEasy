<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class InvoiceController extends Controller
{
    /**
     * Toon de lijst met facturen.
     */
    public function index()
    {
        $invoices = DB::select('CALL spGetInvoices()');

        $invoices = new \Illuminate\Pagination\LengthAwarePaginator(
            collect($invoices)->forPage(\Request::get('page', 1), 12),
            count($invoices),
            12
        );
        
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Toon details van een specifieke factuur.
     */
    public function show($id)
    {
        $invoice = DB::select('CALL spGetInvoiceById(?)', [$id]);

        if (empty($invoice)) {
            abort(404);
        }

        return view('invoice.show', ['invoice' => $invoice[0]]);
    }

    /**
     * Toon de create view voor een nieuwe factuur.
     */
    public function create()
    {
        $bookings = DB::table('bookings')->get();
        $latestInvoice = DB::table('invoices')->latest('id')->first();
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

        DB::statement('CALL spAddInvoice(?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->number,
            now()->toDateString(),
            $request->status,
            $request->amount_excl_vat,
            $vat,
            $total,
            $request->note,
            $request->booking_id,
        ]);

        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol aangemaakt.');
    }

    /**
     * Update een bestaande factuur.
     */
    public function update(Request $request, $id)
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
            $id,
            $request->date,
            $request->status,
            $request->amount_excl_vat,
            $vat,
            $total,
            $request->note,
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
}
