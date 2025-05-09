<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
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
            'comment' => 'required|string|max:500'
        ]);
        $task->tasks_comments()->create([
            'comment'=>$request->comment,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'comment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskComment $taskComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskComment $taskComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskComment $taskComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskComment $taskComment)
    {
        //
    }
}
