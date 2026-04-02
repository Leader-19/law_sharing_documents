<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get all documents with their category
        $documents = Document::with('category')->get();

        // Get all categories
        $categories = Category::all();

        // Check if this is an Inertia request
        if ($request->header('X-Inertia')) {
            // Return Inertia response for Inertia requests
            return Inertia::render('Documents/DocumentIndex', [
                'documents' => $documents,
                'categories' => $categories,
            ]);
        }

        // Return JSON response for regular API requests
        return response()->json([
            'status' => 'success',
            'documents' => $documents,
            'categories' => $categories,
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
