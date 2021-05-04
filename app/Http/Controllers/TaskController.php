<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskStatus;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->paginate();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }
        $task = new Task();
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        return view('tasks.create', compact('task', 'taskStatuses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403);
        }
        $data = $request->validate([
            'name' => 'required|unique:tasks',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|integer'
        ]);

        $user = Auth::user();;
        
        $task = $user->tasks()->make();
        $task->fill($data);
        $task->creator()->associate($user);
        
        if (!is_null($data['assigned_to_id'])) {
            $executor = User::findOrFail($data['assigned_to_id']);
            $task->executor()->associate($executor);
        }

        $task->save();

        flash(__('Task has been added successfully'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        return view('tasks.edit', compact('task', 'taskStatuses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|unique:tasks,name,' . $task->id
        ]);

        $task->fill($data);
        $task->save();
        flash(__('Task has been updated successfully'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task) {
            if (Auth::id() !== $task->creator->id) {
                abort(403);
            }
            $task->delete();
        }

        flash(__('Task has been deleted successfully'))->success();
        return redirect()->route('tasks.index');
    }
}
