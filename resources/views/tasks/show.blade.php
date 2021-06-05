@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">
        {{ __('tasks.View a task') . ": ". $task->name }}
        <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">⚙</a>
    </h1>
    <div class="row">
        <div class="col">
            <p>{{ __('tasks.Task name') . ": ". $task->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>{{ __('taskStatuses.Status') . ": ". $task->status->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>{{ __('tasks.Description') . ": ". $task->description }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>{{ __('labels.Labels') . ": " }}</p>
            @if ($task->labels)
                <ul>
                    @foreach ($task->labels as $label)
                        <li>{{ $label->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection