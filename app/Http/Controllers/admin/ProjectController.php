<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'price' => 'required|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'location' => 'required',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');
        $logoPath = $request->file('logo') ? $request->file('logo')->store('uploads', 'public') : null;
        $qrCodePath = $request->file('qr_code') ? $request->file('qr_code')->store('uploads', 'public') : null;

        $project = Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'price' => $request->input('price'),
            'logo' => $logoPath,
            'qr_code' => $qrCodePath,
            'location' => $request->input('location'),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }
}
