@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">
        {{ __('View a task') . ": ". $task->name }}
        <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">⚙</a>
    </h1>
    <div class="row">
        <div class="col">
            <p>{{ __('Task name') . ": ". $task->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>{{ __('Status') . ": ". $task->status->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>{{ __('Description') . ": ". $task->description }}</p>
        </div>
    </div>
</div>
@endsection