<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function create()
    {
        return view('contacts.create');
    }

    // ✅ Add this method to fix the 500 error:
    public function index()
    {
        return response()->json(Contact::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
        ]);

        Contact::create($validated);

        return response()->json(['message' => 'Contact saved successfully']);
    }
}
