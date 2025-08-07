<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Personnel::query();
        
        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('rank') && $request->rank) {
            $query->where('rank', $request->rank);
        }
        
        if ($request->has('department') && $request->department) {
            $query->where('department', 'ILIKE', "%{$request->department}%");
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('badge_number', 'ILIKE', "%{$search}%")
                  ->orWhere('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $personnel = $query->paginate(15)->appends($request->query());
        
        return Inertia::render('personnel/index', [
            'personnel' => $personnel,
            'filters' => $request->only(['status', 'rank', 'department', 'search', 'sort_by', 'sort_order'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('personnel/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonnelRequest $request)
    {
        $validatedData = $request->validated();
        
        // Handle file uploads
        if ($request->hasFile('documents')) {
            $files = [];
            foreach ($request->file('documents') as $file) {
                $path = $file->store('personnel-documents', 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $validatedData['documents'] = $files;
        }
        
        $personnel = Personnel::create($validatedData);
        
        return redirect()->route('personnel.show', $personnel)
            ->with('success', 'Personnel record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Personnel $personnel)
    {
        return Inertia::render('personnel/show', [
            'personnel' => $personnel
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        return Inertia::render('personnel/edit', [
            'personnel' => $personnel
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonnelRequest $request, Personnel $personnel)
    {
        $validatedData = $request->validated();
        
        // Handle file uploads
        if ($request->hasFile('documents')) {
            $files = $personnel->documents ?? [];
            foreach ($request->file('documents') as $file) {
                $path = $file->store('personnel-documents', 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $validatedData['documents'] = $files;
        }
        
        $personnel->update($validatedData);
        
        return redirect()->route('personnel.show', $personnel)
            ->with('success', 'Personnel record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personnel $personnel)
    {
        // Delete associated files
        if ($personnel->documents) {
            foreach ($personnel->documents as $file) {
                Storage::disk('public')->delete($file['path']);
            }
        }
        
        $personnel->delete();
        
        return redirect()->route('personnel.index')
            ->with('success', 'Personnel record deleted successfully.');
    }
}