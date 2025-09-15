<?php
namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    // Fetch all people
    public function index(Request $request)
    {
        $people = Person::all();

        // If it's an API/Ajax request, return JSON
        if ($request->wantsJson()) {
            return response()->json($people);
        }

        // Otherwise, return people.blade.php
        return view('people', compact('people'));
    }

    // Show create form
    public function create()
    {
        return view('people'); // you only have people.blade.php
    }

    // Create a new person
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer',
            'bio'  => 'required|string|max:1000',
        ]);

        $person = Person::create($validated);

        if ($request->wantsJson()) {
            return response()->json($person, 201);
        }

        return redirect()->route('people.index')->with('success', 'Person created successfully!');
    }

    // Show a specific person
    public function show(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($person);
        }

        return view('people', compact('person'));
    }

    // Show edit form
    public function edit($id)
    {
        $person = Person::findOrFail($id);
        return view('people', compact('person'));
    }

    // Update an existing person
    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer',
            'bio'  => 'required|string|max:1000',
        ]);

        $person->update($validated);

        if ($request->wantsJson()) {
            return response()->json($person);
        }

        return redirect()->route('people.index')->with('success', 'Person updated successfully!');
    }

    // Delete a person
    public function destroy(Request $request, $id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Person deleted successfully']);
        }

        return redirect()->route('people.index')->with('success', 'Person deleted successfully!');
    }
}
