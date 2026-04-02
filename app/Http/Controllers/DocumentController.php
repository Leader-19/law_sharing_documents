<?php

namespace App\Http\Controllers;

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
        $documents = Document::with('category')->get();
        $categories = Category::all();

        // Always return Inertia response for Inertia requests
        return Inertia::render('Documents/DocumentIndex', [
            'documents' => $documents,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Documents/DocumentCreate', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_name' => 'required|string|max:255',
            'doc_title' => 'required|string|max:255',
            'doc_upload' => 'required|file|max:100000',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);

        $path = $request->file('doc_upload')->store('documents', 'public');

        Document::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'doc_name' => $request->doc_name,
            'doc_title' => $request->doc_title,
            'doc_upload' => $path,
            'description' => $request->description,
        ]);

        // Use redirect with Inertia for successful creation
        return redirect()->route('documents.index')
            ->with('success', 'Document created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::with('category')->findOrFail($id);

        return Inertia::render('Documents/DocumentDetails', [
            'document' => $document,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        $categories = Category::all();

        return Inertia::render('Documents/DocumentUpdate', [
            'document' => $document,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'doc_name' => 'required|string|max:255',
            'doc_title' => 'required|string|max:255',
            'doc_upload' => 'nullable|file|max:100000',
            'description' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $document->doc_name = $request->doc_name;
        $document->doc_title = $request->doc_title;
        $document->description = $request->description;
        $document->category_id = $request->category_id;

        if ($request->hasFile('doc_upload')) {
            $path = $request->file('doc_upload')->store('documents', 'public');
            $document->doc_upload = $path;
        }

        $document->save();

        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);

        // Optionally delete the uploaded file
        if ($document->doc_upload) {
            \Storage::disk('public')->delete($document->doc_upload);
        }

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully!');
    }
}