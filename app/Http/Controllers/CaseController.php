<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Models\Cases;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cases::with(['assignedOfficer', 'creator']);
        
        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('case_number', 'ILIKE', "%{$search}%")
                  ->orWhere('title', 'ILIKE', "%{$search}%")
                  ->orWhere('description', 'ILIKE', "%{$search}%");
            });
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $cases = $query->paginate(15)->appends($request->query());
        
        $officers = User::officers()->get();
        
        return Inertia::render('cases/index', [
            'cases' => $cases,
            'officers' => $officers,
            'filters' => $request->only(['status', 'priority', 'category', 'search', 'sort_by', 'sort_order'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $officers = User::officers()->get();
        
        return Inertia::render('cases/create', [
            'officers' => $officers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaseRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->id();
        
        // Handle file uploads
        if ($request->hasFile('evidence_files')) {
            $files = [];
            foreach ($request->file('evidence_files') as $file) {
                $path = $file->store('evidence', 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $validatedData['evidence_files'] = $files;
        }
        
        $case = Cases::create($validatedData);
        
        return redirect()->route('cases.show', $case)
            ->with('success', 'Case created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cases $case)
    {
        $case->load(['assignedOfficer', 'creator']);
        
        return Inertia::render('cases/show', [
            'case' => $case
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cases $case)
    {
        $officers = User::officers()->get();
        
        return Inertia::render('cases/edit', [
            'case' => $case,
            'officers' => $officers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCaseRequest $request, Cases $case)
    {
        $validatedData = $request->validated();
        
        // Handle file uploads
        if ($request->hasFile('evidence_files')) {
            $files = $case->evidence_files ?? [];
            foreach ($request->file('evidence_files') as $file) {
                $path = $file->store('evidence', 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $validatedData['evidence_files'] = $files;
        }
        
        $case->update($validatedData);
        
        return redirect()->route('cases.show', $case)
            ->with('success', 'Case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cases $case)
    {
        // Delete associated files
        if ($case->evidence_files) {
            foreach ($case->evidence_files as $file) {
                Storage::disk('public')->delete($file['path']);
            }
        }
        
        $case->delete();
        
        return redirect()->route('cases.index')
            ->with('success', 'Case deleted successfully.');
    }
}