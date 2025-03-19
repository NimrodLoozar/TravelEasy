<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public function index()
    {
        $communications = Communication::with(['customer', 'employee'])->paginate(10);
        return view('communications.index', compact('communications'));
    }

    public function create()
    {
        return view('communications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'message' => 'required|string',
            'sent_date' => 'required|date',
            'is_active' => 'sometimes|boolean',
            'note' => 'nullable|string'
        ]);

        Communication::create($validated);
        return redirect()->route('communications.index')->with('success', 'Communication created successfully.');
    }

    public function show(Communication $communication)
    {
        return view('communications.show', compact('communication'));
    }

    public function edit(Communication $communication)
    {
        return view('communications.edit', compact('communication'));
    }

    public function update(Request $request, Communication $communication)
    {
        $validated = $request->validate([
            'customer_id' => 'sometimes|exists:customers,id',
            'employee_id' => 'sometimes|exists:employees,id',
            'message' => 'sometimes|string',
            'sent_date' => 'sometimes|date',
            'is_active' => 'sometimes|boolean',
            'note' => 'nullable|string'
        ]);

        $communication->update($validated);
        return redirect()->route('communications.index')->with('success', 'Communication updated successfully.');
    }

    public function destroy(Communication $communication)
    {
        $communication->delete();
        return redirect()->route('communications.index')->with('success', 'Communication deleted successfully.');
    }
}
