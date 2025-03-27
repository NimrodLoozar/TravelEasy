<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReizenOverzicht;

class ReizenOverzichtController extends Controller
{
    public function index()
    {
        $reizen = ReizenOverzicht::with(['departure', 'destination'])->get(); // Haal gerelateerde gegevens op
        return view('reisoverzicht.index', compact('reizen'));
    }

    public function show($id)
    {
        $reis = ReizenOverzicht::findOrFail($id);
        return view('reisoverzicht.show', compact('reis'));
    }

    public function create()
    {
        return view('reisoverzicht.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'airport' => 'required|string|max:255',
            'departure_id' => 'required|integer', // Ensure departure_id is an integer
            'departure_date' => 'required|date', // Ensure this is validated as 'date'
            'departure_time' => 'required|date_format:H:i',
            'destination_id' => 'required|integer', // Ensure destination_id is an integer
            'arrival_date' => 'required|date', // Ensure this is validated as 'date'
            'arrival_time' => 'required|date_format:H:i',
            'is_active' => 'required|boolean',
            'note' => 'nullable|string',
        ]);

        ReizenOverzicht::create($request->all());

        return redirect()->route('reisoverzicht.index')->with('success', 'Reis succesvol aangemaakt.');
    }

    public function edit($id)
    {
        $reis = ReizenOverzicht::findOrFail($id);
        return view('reisoverzicht.edit', compact('reis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'airport' => 'required|string|max:255',
            //'departure_id' => 'required|integer', // Ensure departure_id is an integer
            'departure_date' => 'required|date', // Ensure this is validated as 'date'
            'departure_time' => 'required|date_format:H:i',
            //'destination_id' => 'required|integer', // Ensure destination_id is an integer
            'arrival_date' => 'required|date', // Ensure this is validated as 'date'
            'arrival_time' => 'required|date_format:H:i',
            'is_active' => 'required|boolean',
            'note' => 'nullable|string',
        ]);

        $reis = ReizenOverzicht::findOrFail($id);
        $reis->update($request->all());

        return redirect()->route('reisoverzicht.index')->with('success', 'Reis succesvol bijgewerkt.');
    }

    public function destroy($id)
    {
        $reis = ReizenOverzicht::findOrFail($id);
        $reis->delete();

        return redirect()->route('reisoverzicht.index')->with('success', 'Reis succesvol verwijderd.');
    }
}