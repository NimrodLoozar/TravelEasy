<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Customer;
use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Toon een lijst van alle klanten.
     */
    public function index()
    {
        // Haal alle klanten op met hun gerelateerde personen en contacten in aflopende volgorde
        $accounts = Customer::with(['person', 'contacts'])->orderBy('created_at', 'desc')->get();
        return view('account.index', compact('accounts'));
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'passport_details' => 'nullable|string',
            'is_active' => 'boolean',
            'relation_number' => 'required|string|unique:customers,relation_number',
            'email' => 'required|email|unique:contacts,email',
            'mobile' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
        ]);

        // Maak een nieuw persoon aan
        $person = Person::create($request->only([
            'first_name', 'middle_name', 'last_name', 'birth_date', 'passport_details', 'is_active'
        ]));

        // Maak de klant aan en koppel deze aan de persoon
        $customer = Customer::create([
            'person_id' => $person->id,
            'relation_number' => $request->relation_number,
            'is_active' => $request->is_active ?? true,
        ]);

        // Maak het contact aan en koppel dit aan de klant
        Contact::create([
            'customer_id' => $customer->id,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'street' => $request->street,
            'house_number' => $request->house_number,
            'addition' => $request->addition,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'is_active' => true,
        ]);

        return redirect()->route('account.index')->with('success', 'Account succesvol aangemaakt.');
    }

    /**
     * Toon een specifiek account.
     */
    public function show(Customer $customer)
    {
        $customer->load(['person', 'contacts']);
        return view('account.show', compact('customer'));
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
