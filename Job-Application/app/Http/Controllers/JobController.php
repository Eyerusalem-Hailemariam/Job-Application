<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth:api'); 
    }
    public function createJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:20-max:2000',
            'location' => 'optional|string|max:255',
        ]); 
      
        $user = Auth::user();
        if ($user->role !== 'company') {
            return response()->json(['message' => 'Unauthorized. Only companies can create jobs.'], 403);
        }

        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Job created successfully',
            'job' => $job
        ], 201);
    }

    
    public function updateJob(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:20|max:2000',
            'location' => 'optional|string|max:255',
        ]);         

       
        $user = Auth::user();
        if ($user->role !== 'company') {
            return response()->json(['message' => 'Unauthorized. Only companies can update jobs.'], 403);
        }

        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);       

       
        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
        ]);

        return response()->json([
            'message' => 'Job updated successfully',
            'job' => $job
        ], 200);
    }
    }

    public function deleteJob($id)
    {
        $user = Auth::user();
        if ($user->role !== 'company') {
            return response()->json(['message' => 'Unauthorized. Only companies can delete jobs.'], 403);
        }

        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);
    }
}
