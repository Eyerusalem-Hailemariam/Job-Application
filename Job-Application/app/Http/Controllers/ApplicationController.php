<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ApplicationController extends Controller
{
    public function apply(Request $request, $jobId)
    {
        $user = Auth::user();

        
        if ($user->role !== 'applicant') {
            return response()->json(['message' => 'Only applicants can apply for jobs.'], 403);
        }

    
        $existing = Application::where('job_id', $jobId)
            ->where('applicant_id', $user->id)
            ->first();

        if ($existing) {
            throw ValidationException::withMessages([
                'job_id' => ['You have already applied for this job.']
            ]);
        }

        
        $validated = $request->validate([
            'resume' => 'required|file|mimes:pdf|max:5120',
            'cover_letter' => 'nullable|string|max:200',
        ]);

      
        $uploadedFile = Cloudinary::uploadFile($request->file('resume')->getRealPath(), [
            'folder' => 'resumes',
            'resource_type' => 'auto'
        ]);

        $resumeLink = $uploadedFile->getSecurePath();

     
        $application = Application::create([
            'applicant_id' => $user->id,
            'job_id' => $jobId,
            'resume_link' => $resumeLink,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'Applied',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Application submitted successfully.',
            'application' => $application,
        ], 201);
    }
}

