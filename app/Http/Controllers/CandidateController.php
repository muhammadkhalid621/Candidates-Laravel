<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;


class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidate::all();
        return view('candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('candidates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:candidates',
            'phone' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'resume' => 'nullable|mimes:pdf,doc,docx',
        ]);

        $candidate = new Candidate($request->all());

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $candidate->resume = $resumePath;
            $candidate->save();
        }


        return redirect()->route('candidates.index')->with('success', 'Candidate added successfully');
    }


    public function show(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // echo $candidate;
        // $data = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:candidates,email,',
        //     'phone' => 'required',
        //     'dob' => 'required|date',
        //     'address' => 'required',
        //     'resume' => 'nullable|mimes:pdf,doc,docx',
        // ]);

        // $candidate = Candidate::findOrFail($id);
        // $candidate->name = $request->input('name');
        // $candidate->email = $request->input('email');
        // $candidate->phone = $request->input('phone');
        // $candidate->dob = $request->input('dob');
        // $candidate->address = $request->input('address');



        // if ($request->hasFile('resume')) {
        //     if ($candidate->resume_path) {
        //         Storage::delete($candidate->resume_path);
        //     }
        //     $resumePath = $request->file('resume')->store('resumes', 'public');
        //     $candidate->resume = $resumePath;
        // }
        // print_r($candidate);
        // // $candidate->update();
        // $candidate->save($data);

        // Retrieve the candidate based on your condition
        $candidate = Candidate::where('id', $id)->first();

        if (!$candidate) {
            return redirect()->route('candidates.index')->with('error', 'Candidate not found');
        }

        // Update the candidate's attributes
        $candidate->name = $request->input('name');
        $candidate->email = $request->input('email');
        $candidate->phone = $request->input('phone');
        $candidate->dob = $request->input('dob');
        $candidate->address = $request->input('address');

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $candidate->resume = $resumePath;
        }

        $candidate->save();


        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        // Delete resume file if exists
        if ($candidate->resume_path) {
            Storage::delete($candidate->resume_path);
        }

        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully');
    }
}
