<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceController extends Controller
{
    /**
     * Toon de lijst met facturen.
     */
    public function index()
{
    $invoices = DB::select('CALL spGetInvoices()') ?? [];

    $currentPage = request('page', 1); // Correct way to get query parameters
    $perPage = 12;

    $paginatedInvoices = new LengthAwarePaginator(
        collect($invoices)->forPage($currentPage, $perPage),
        count($invoices),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()] // Ensure pagination works properly
    );

    return view('invoice.index', compact('paginatedInvoices'));
}

    /**
     * Toon details van een specifieke factuur.
     */
    public function show($id)
        {
            $invoices = DB::select('CALL spGetInvoiceById(?)', [$id]);

            if (empty($invoices)) {
                abort(404, 'Factuur niet gevonden.');
            }

            return view('invoice.show', ['invoices' => $invoices[0]]);
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
