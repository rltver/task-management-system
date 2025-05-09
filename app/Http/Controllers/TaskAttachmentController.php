<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;

class TaskAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'attachment.*' => 'nullable|max:5120'
        ]);

        if($request->hasFile('attachment')){
            foreach($request->file('attachment') as $file){
                $filePath = $file->store('attachments', 'public');

                $task->tasks_attachment()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'files added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskAttachment $taskAttachment)
    {
        //
    }
}
