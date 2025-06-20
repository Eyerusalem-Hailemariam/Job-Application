<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class BrowserController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('creator'); 
        if ($request->has('title')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($request->input('title')) . '%']);
        }

        
        if ($request->has('location')) {
            $query->where('location', 'LIKE', '%' . $request->input('location') . '%');
        }

       
        if ($request->has('company_name')) {
            $companyName = $request->input('company_name');
            $query->whereHas('creator', function ($q) use ($companyName) {
                $q->where('name', '=', $companyName); 
            });
        }

        $pageNumber = $request->input('page_number', 1);
        $pageSize   = $request->input('page_size', 10);

        $jobs = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

        return response()->json($jobs);
    }
}
