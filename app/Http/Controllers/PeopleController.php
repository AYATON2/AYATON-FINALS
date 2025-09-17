<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeopleController extends Controller
{
    // API: GET /people — return all non-archived people as JSON
    public function getAll()
    {
        $people = People::where('is_archived', 0)->get();
        return response()->json($people);
    }

    // Web: GET /people — return people.blade.php view with non-archived people
    public function index()
    {
        $people = People::where('is_archived', 0)->get();
        return view('people', compact('people'));
    }

    // POST /people — create new person (returns JSON)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer',
            'bio'  => 'required|string',
        ]);

        $person = People::create($validated);

        return response()->json([
            'message' => 'Person created successfully',
            'data'    => $person
        ]);
    }

    // GET /people/{id} — show specific person (returns JSON)
    public function show($id)
    {
        $person = People::findOrFail($id);
        return response()->json($person);
    }

    // PUT /people/{id}/archive — mark as archived (returns JSON)
    public function archive($id)
    {
        $person = People::findOrFail($id);
        $person->is_archived = 1;
        $person->archived_at = Carbon::now();
        $person->save();

        return response()->json([
            'message' => 'Person archived successfully',
            'data'    => $person
        ]);
    }

    // PUT /people/{id}/restore — un-archive person (returns JSON)
    public function restoreFromArchive($id)
    {
        $person = People::findOrFail($id);
        $person->is_archived = 0;
        $person->archived_at = null;
        $person->save();

        return response()->json([
            'message' => 'Person restored from archive successfully',
            'data'    => $person
        ]);
    }

    // GET /people-archived — list all archived people (returns JSON)
    public function archivedPeople()
    {
        $archived = People::where('is_archived', 1)->get();
        return response()->json($archived);
    }

    // PUT /people/{id} — update person info (returns JSON)
    public function update(Request $request, $id)
    {
        $person = People::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'age'  => 'sometimes|integer',
            'bio'  => 'sometimes|string',
        ]);

        $person->update($validated);

        return response()->json([
            'message' => 'Person updated successfully',
            'data'    => $person
        ]);
    }

    // DELETE /people/{id} — soft delete (returns JSON)
    public function destroy($id)
    {
        $person = People::findOrFail($id);
        $person->delete();

        return response()->json([
            'message' => 'Person soft deleted successfully'
        ]);
    }

    // DELETE /people/{id}/force — force delete from DB (returns JSON)
    public function forceDelete($id)
    {
        $person = People::withTrashed()->findOrFail($id);
        $person->forceDelete();

        return response()->json([
            'message' => 'Person permanently deleted from database'
        ]);
    }
}
