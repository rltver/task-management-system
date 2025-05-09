<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $column = $request->get('sort','due_date');
        $direction = $request->get('direction','asc');

        $query = Task::with('category');
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('title')) {
            $query->where('title','like', '%'.$request->title.'%');
        }

        if ($request->filled('status')) {
            $query->where('status','like', '%'.$request->status.'%');
        }

        $categories = Category::all();
        $tasks = $query->orderBy($column,$direction)->paginate(10);
        return view('tasks.index', compact('tasks','column','direction','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100|min:5',
            'description' => 'nullable|max:500',
            'category_id' => 'required',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required',
            'attachment.*' => 'nullable|max:5120'
        ]);
        $task = new Task;
        $task =Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'user_id' => auth()->id(),
            'status' => 0,
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


        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
//        $task = Task::find($id);
        $task->load(['category','tasks_attachment','tasks_comments.user','tasks_history.user','user']);
        $categories = Category::all();
        return view('tasks.show', compact('task','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:100|min:5',
            'description' => 'nullable|max:500',
            'category_id' => 'required',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required',
        ]);


        if ($task->title!=request('title')) {
            $task->tasks_history()->create([
                'user_id' => auth()->id(),
                'action' => 'title changed',
                'old_value' => $task->title,
                'new_value' => request('title')
            ]);
        }
        if ($task->description!=request('description')) {
            $task->tasks_history()->create([
                'user_id' => auth()->id(),
                'action' => 'description changed',
                'old_value' => $task->description,
                'new_value' => request('description')
            ]);
        }

        if ($task->category_id!=request('category_id')) {
            $task->tasks_history()->create([
                'user_id' => auth()->id(),
                'action' => 'category changed',
                'old_value' => $task->category_id,
                'new_value' => request('category_id')
            ]);
        }

        if ($task->due_date->toDateString()!=request('due_date')) {
            $task->tasks_history()->create([
                'user_id' => auth()->id(),
                'action' => 'due date changed',
                'old_value' => $task->due_date,
                'new_value' => request('due_date')
            ]);
        }

        if ($task->priority!=request('priority')) {
            $task->tasks_history()->create([
                'user_id' => auth()->id(),
                'action' => 'priority changed',
                'old_value' => $task->priority,
                'new_value' => request('priority')
            ]);
        }




        $task->update([
            'title' =>  request('title'),
            'description' =>  request('description'),
            'category_id' =>  request('category_id'),
            'due_date' =>  request('due_date'),
            'priority' =>  request('priority'),
        ]);

        return redirect()->route('tasks.show', $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        $task->tasks_history()->delete();
        $task->tasks_comments()->delete();
        $task->tasks_attachment()->delete();

        return redirect()->route('tasks.index');
    }

    public function restore($id){
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();
        $task->tasks_history()->restore();
        $task->tasks_comments()->restore();
        $task->tasks_attachment()->restore();
        return redirect()->route('tasks.deletedTasks');
    }

    public function forceDelete($id){
        $task = Task::withTrashed()->with(['tasks_attachment' => function ($query) {
            $query->withTrashed();
        }])->findOrFail($id);
        foreach ($task->tasks_attachment as $task_attachment){
            if (Storage::disk('public')->exists($task_attachment->file_path)){
                Storage::disk('public')->delete($task_attachment->file_path);
            }
        }
        $task->forceDelete();

        return redirect()->route('tasks.deletedTasks');
    }

    public function deletedTasks(Request $request){
        $column = $request->get('sort','due_date');
        $direction = $request->get('direction','asc');

        $query = Task::onlyTrashed()->with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('title')) {
            $query->where('title','like', '%'.$request->title.'%');
        }

        if ($request->filled('status')) {
            $query->where('status','like', '%'.$request->status.'%');
        }

        $categories = Category::all();
        $tasks = $query->orderBy($column,$direction)->paginate(10);
        return view('tasks.deletedTasks', compact('tasks','column','direction','categories'));
    }

    public function updateStatus(Request $request, Task $task){

        $task->tasks_history()->create([
            'user_id' => auth()->id(),
            'action' => 'status changed',
            'old_value' => $task->status,
            'new_value' => request('status')
        ]);

        if($request->status){
            $task->update([
                'status' => 1
            ]);
        }else{
            $task->update([
                'status' => 0
            ]);
        }

        return redirect()->route('tasks.show', $task);
    }
}
