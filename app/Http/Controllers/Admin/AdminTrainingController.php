<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use Illuminate\Support\Facades\Storage;

class AdminTrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::orderBy('order_column')->get();
        return view('admin.training.index', compact('trainings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'order_column' => 'nullable|integer'
        ]);

        $data = $request->except('thumbnail');
        
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('trainings', 'public');
        }

        $data['order_column'] = $request->order_column ?? Training::max('order_column') + 1;

        Training::create($data);

        return back()->with('success', 'Training video added successfully.');
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'order_column' => 'nullable|integer'
        ]);

        $data = $request->except('thumbnail');
        
        if ($request->hasFile('thumbnail')) {
            if ($training->thumbnail) {
                Storage::disk('public')->delete($training->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('trainings', 'public');
        }

        $training->update($data);

        return back()->with('success', 'Training video updated successfully.');
    }

    public function destroy(Training $training)
    {
        if ($training->thumbnail) {
            Storage::disk('public')->delete($training->thumbnail);
        }
        $training->delete();
        
        return back()->with('success', 'Training video deleted successfully.');
    }

    public function toggle(Training $training)
    {
        $training->update(['is_active' => !$training->is_active]);
        return back()->with('success', 'Training status updated.');
    }
}
