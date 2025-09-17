<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class PeopleController extends Controller
{
    // Show all people (including archived)
    public function index()
    {
        $people = Person::all();  // Fetch all people, including archived
        return response()->json($people);
    }

    // Store a new person
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'bio' => 'required|string',
        ]);

        $person = Person::create($validated);
        return response()->json(['message' => 'Person saved successfully', 'data' => $person]);
    }

    // Show a single person (active or archived)
    public function show($id)
    {
        $person = Person::findOrFail($id);
        return response()->json($person);
    }

    // Archive a person (soft archive)
    public function archive($id)
    {
        $person = Person::findOrFail($id);

        // Check if already archived
        if ($person->is_archived) {
            return response()->json(['message' => 'This person is already archived.'], 400);
        }

        $person->is_archived = 1;
        $person->archived_at = now(); // Set the current timestamp for archiving
        $person->save();

        return response()->json(['message' => 'Person archived successfully']);
    }

    // Show archived people
    public function archivedPeople()
    {
        $archivedPeople = Person::where('is_archived', 1)->get(); // Fetch only archived people
        return response()->json($archivedPeople);
    }

    // Delete a person permanently (soft delete)
    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();  // Soft delete the person (set deleted_at timestamp)

        return response()->json(['message' => 'Person deleted successfully']);
    }

    // Permanently delete an archived person
    public function forceDelete($id)
    {
        try {
            // Fetch the person, including soft-deleted ones
            $person = Person::withTrashed()->findOrFail($id);

            // Ensure the person is archived before allowing permanent deletion
            if (!$person->is_archived) {
                return response()->json(['message' => 'This person is not archived and cannot be deleted permanently.'], 400);
            }

            // Permanently delete the person from the database
            $person->forceDelete();

            return response()->json(['message' => 'Person permanently deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete person permanently', 'message' => $e->getMessage()], 500);
        }
    }

    // Restore an archived person
    public function restoreFromArchive($id)
    {
        try {
            // Fetch the person, including soft-deleted ones
            $person = Person::withTrashed()->findOrFail($id);

            // Check if the person is archived
            if (!$person->is_archived) {
                return response()->json(['message' => 'This person is not archived'], 400);
            }

            // Restore the person to the active list
            $person->is_archived = 0;
            $person->archived_at = null;  // Clear archived timestamp
            $person->save();

            return response()->json(['message' => 'Person restored successfully to the main list']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore person', 'message' => $e->getMessage()], 500);
        }
    }
}

