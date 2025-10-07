<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyProgramRequest;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = StudyProgram::query();

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply degree filter
        if ($request->filled('degree')) {
            $query->byDegree($request->degree);
        }

        // Apply status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->featured();
                    break;
            }
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $programs = $query->paginate(10)->withQueryString();

        return view('admin.study-programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.study-programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudyProgramRequest $request): RedirectResponse
    {
        try {
            $data = $request->getProcessedData();

            // Handle file uploads
            if ($request->hasFile('program_image')) {
                $data['program_image'] = $this->uploadFile($request->file('program_image'), 'study-programs/images');
            }

            if ($request->hasFile('brochure_file')) {
                $data['brochure_file'] = $this->uploadFile($request->file('brochure_file'), 'study-programs/brochures');
            }

            $studyProgram = StudyProgram::create($data);

            return redirect()
                ->route('admin.study-programs.index')
                ->with('success', 'Study program created successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create study program: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyProgram $studyProgram): View
    {
        return view('admin.study-programs.show', compact('studyProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyProgram $studyProgram): View
    {
        return view('admin.study-programs.edit', compact('studyProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudyProgramRequest $request, StudyProgram $studyProgram): RedirectResponse
    {
        try {
            $data = $request->getProcessedData();

            // Handle file uploads
            if ($request->hasFile('program_image')) {
                // Delete old image if exists
                if ($studyProgram->program_image) {
                    Storage::disk('public')->delete($studyProgram->program_image);
                }
                $data['program_image'] = $this->uploadFile($request->file('program_image'), 'study-programs/images');
            }

            if ($request->hasFile('brochure_file')) {
                // Delete old brochure if exists
                if ($studyProgram->brochure_file) {
                    Storage::disk('public')->delete($studyProgram->brochure_file);
                }
                $data['brochure_file'] = $this->uploadFile($request->file('brochure_file'), 'study-programs/brochures');
            }

            $studyProgram->update($data);

            return redirect()
                ->route('admin.study-programs.index')
                ->with('success', 'Study program updated successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update study program: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyProgram $studyProgram): RedirectResponse
    {
        try {
            // Delete associated files
            if ($studyProgram->program_image) {
                Storage::disk('public')->delete($studyProgram->program_image);
            }

            if ($studyProgram->brochure_file) {
                Storage::disk('public')->delete($studyProgram->brochure_file);
            }

            $studyProgram->delete();

            return redirect()
                ->route('admin.study-programs.index')
                ->with('success', 'Study program deleted successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete study program: ' . $e->getMessage());
        }
    }

    /**
     * Activate a study program.
     */
    public function activate(StudyProgram $studyProgram): JsonResponse
    {
        try {
            $studyProgram->activate();

            return response()->json([
                'success' => true,
                'message' => 'Study program activated successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate study program: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Deactivate a study program.
     */
    public function deactivate(StudyProgram $studyProgram): JsonResponse
    {
        try {
            $studyProgram->deactivate();

            return response()->json([
                'success' => true,
                'message' => 'Study program deactivated successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate study program: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Feature a study program.
     */
    public function feature(StudyProgram $studyProgram): JsonResponse
    {
        try {
            $studyProgram->feature();

            return response()->json([
                'success' => true,
                'message' => 'Study program featured successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to feature study program: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Unfeature a study program.
     */
    public function unfeature(StudyProgram $studyProgram): JsonResponse
    {
        try {
            $studyProgram->unfeature();

            return response()->json([
                'success' => true,
                'message' => 'Study program unfeatured successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unfeature study program: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload file to storage.
     */
    private function uploadFile($file, string $directory): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        
        return 'storage/' . $path;
    }
}