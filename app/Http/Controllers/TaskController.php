<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ])
            ->orderBy('id', 'asc')
            ->paginate();
        $filter = $request->filter ?? null;
        return view('tasks.index', compact('tasks', 'taskStatuses', 'users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $task = new Task();
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        return view('tasks.create', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:tasks',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|integer',
            'labels' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $user = Auth::user();
        $task = $user->tasks()->make();
        $task->fill($data);
        $task->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $task->labels()->attach($labels);

        flash(__('tasks.Task has been added successfully'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required|unique:tasks,name,' . $task->id,
            'status_id' => 'required',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|integer',
            'labels' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $task->fill($data);
        $task->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $task->labels()->sync($labels);

        flash(__('tasks.Task has been updated successfully'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();

        flash(__('tasks.Task has been deleted successfully'))->success();
        return redirect()->route('tasks.index');
    }
}
