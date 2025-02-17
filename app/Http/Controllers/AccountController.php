<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Person;
use App\Models\Customer;
use App\Models\Contact;
use Carbon\Carbon;


class AccountController extends Controller
{
    /**
     * Toon een lijst van alle klanten.
     */
    public function index()
    {
        // Call the stored procedure
        try {
            $accounts = DB::select('CALL spGetAccounts()') ?? [];
        } catch (\Exception $e) {
            // Log the error and return an empty array
            Log::error('Failed to fetch accounts: ' . $e->getMessage());
            $accounts = [];
        }

        // Convert the result to a collection
        $accountsCollection = collect($accounts);

        // Paginate the collection
        $currentPage = request('page', 1);
        $perPage = 10;
        $paginatedAccounts = new LengthAwarePaginator(
            $accountsCollection->forPage($currentPage, $perPage),
            $accountsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('account.index', compact('paginatedAccounts'));
    }

    /**
     * Toon het formulier om een nieuw account aan te maken.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Sla een nieuw account op.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'relation_number' => 'required|string|unique:customers,relation_number',
            'email' => 'required|email|unique:contacts,email',
            'mobile' => 'required|string|max:20', // Changed from nullable to required
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Prepare passport details as JSON
        $passportDetails = null;
        if ($request->filled('passport_number') || $request->filled('passport_expiry')) {
            $passportDetails = json_encode([
                'passport_number' => $request->passport_number,
                'passport_expiry' => $request->passport_expiry,
            ]);
        }

        try {
            DB::select('CALL spAddAccount(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['first_name'],
                $validated['middle_name'],
                $validated['last_name'],
                $validated['birth_date'],
                $passportDetails,
                $validated['relation_number'],
                $validated['email'],
                $validated['mobile'],
                $validated['street'],
                $validated['house_number'],
                $validated['addition'],
                $validated['postal_code'],
                $validated['city'],
                $validated['is_active'] ?? true,
            ]);

            return redirect()->route('account.index')
                ->with('success', 'Account succesvol aangemaakt.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van het account.');
        }
    }

    /**
     * Toon een specifiek account.
     */
    public function show($id)
    {
        try {
            $account = collect(DB::select('CALL spGetAccountById(?)', [$id]))->first();
            
            if (!$account) {
                return redirect()->route('account.index')
                    ->with('error', 'Account niet gevonden.');
            }

            return view('account.show', compact('account'));
        } catch (\Exception $e) {
            return redirect()->route('account.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van het account.');
        }
    }

    /**
     * Toon het formulier om een account te bewerken.
     */
    public function edit(Customer $customer)
    {
        $customer->load('person', 'contacts');
        return view('account.edit', compact('customer'));
    }

    /**
     * Werk een bestaand account bij.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'passport_details' => 'nullable|string',
            'is_active' => 'boolean',
            'relation_number' => 'required|string|unique:customers,relation_number,' . $customer->id,
            'email' => 'required|email|unique:contacts,email,' . $customer->contacts->first()->id,
            'mobile' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
        ]);

        // Update persoon
        $customer->person->update($request->only([
            'first_name', 'middle_name', 'last_name', 'birth_date', 'passport_details', 'is_active'
        ]));

        // Update klant
        $customer->update([
            'relation_number' => $request->relation_number,
            'is_active' => $request->is_active ?? true,
        ]);

        // Update contact
        $contact = $customer->contacts->first();
        $contact->update([
            'email' => $request->email,
            'mobile' => $request->mobile,
            'street' => $request->street,
            'house_number' => $request->house_number,
            'addition' => $request->addition,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
        ]);

        return redirect()->route('account.index')->with('success', 'Account succesvol bijgewerkt.');
    }

    /**
     * Verwijder een account.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('account.index')->with('success', 'Account succesvol verwijderd.');
    }
}
