<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Booking;
use App\Models\Invoice;
use Carbon\Carbon;

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
        $bookings = Booking::with('customer.person', 'trip')->get(); // Zorg ervoor dat je de juiste relaties laadt
        $newNumber = Invoice::max('number') + 1; // Of een andere manier om een nieuw factuurnummer te genereren

        return view('invoice.create', compact('bookings', 'newNumber'));
    }


    /**
     * Sla een nieuwe factuur op.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount_excl_vat' => 'required|numeric|min:0',
            'status' => 'required|in:in behandeling,betaald,onbetaald',
            'note' => 'nullable|string|max:500',
        ]);

        // Get the necessary data from the request
        $booking = \App\Models\Booking::findOrFail($validated['booking_id']);
        $amountExclVat = $validated['amount_excl_vat'];
        $vatAmount = $amountExclVat * 0.21; // 21% VAT
        $totalAmount = $amountExclVat + $vatAmount;
       
        $invoiceNumber = Invoice::max('number') + 1;

        $invoiceDate = Carbon::now()->toDateString();
        $status = $validated['status'];
        $note = $validated['note'] ?? ''; // If no note is provided, set to empty string

        // Call the stored procedure to insert the invoice
        DB::statement("
            CALL spAddInvoice(
                :number, 
                :date, 
                :status, 
                :amount_excl_vat, 
                :vat, 
                :amount_incl_vat, 
                :note, 
                :booking_id
            )
        ", [
            'number' => $invoiceNumber,
            'date' => $invoiceDate,
            'status' => $status,
            'amount_excl_vat' => $amountExclVat,
            'vat' => $vatAmount,
            'amount_incl_vat' => $totalAmount,
            'note' => $note,
            'booking_id' => $booking->id,
        ]);

        // Redirect back or show a success message
        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol aangemaakt.');
    }

    public function edit($id)
        {
            // Retrieve the invoice by ID
            $invoice = Invoice::findOrFail($id);

            // Pass the invoice data to the view
            return view('invoice.edit', compact('invoice'));
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

    try {
        DB::statement('CALL spUpdateInvoice(?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->date,
            $request->status,
            $request->amount_excl_vat,
            $vat,
            $total,
            $request->note,
        ]);

        // Log the update
        \Log::info('Factuur bijgewerkt', ['invoice_id' => $id, 'updated_by' => auth()->user()->id]);

        return redirect()->route('invoice.index')->with('success', 'Factuur succesvol bijgewerkt.');
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Fout bij het bijwerken van de factuur', ['error' => $e->getMessage()]);

        return redirect()->back()->with('error', 'Er is een fout opgetreden bij het bijwerken van de factuur.');
    }
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
