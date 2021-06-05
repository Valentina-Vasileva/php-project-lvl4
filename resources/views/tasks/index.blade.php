@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('tasks.Tasks') }}</h1>
    @if(Auth::check())
    <div class="row">
        <div class="col">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-2">{{ __('tasks.Create task') }}</a>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="d-flex">
                <div>
                    {{Form::open(['url' => route('tasks.index'), 'method' => 'GET', 'class' => 'form-inline'])}}
                    {{Form::select('filter[status_id]', $taskStatuses, $filter['status_id'] ?? null, ['placeholder' => __('taskStatuses.Status'), 'class' => 'form-control my-2 mr-2'])}}
                    {{Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? null, ['placeholder' => __('tasks.Author'), 'class' => 'form-control my-2 mr-2'])}}
                    {{Form::select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ?? null, ['placeholder' => __('tasks.Executor'), 'class' => 'form-control my-2 mr-2'])}}
                    {{Form::submit(__('tasks.Apply'), ['class' => 'btn btn-outline-primary mr-2 my-2'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">{{ __('taskStatuses.Status') }}</th>
                        <th scope="col">{{ __('tasks.Task name') }}</th>
                        <th scope="col">{{ __('tasks.Author') }}</th>
                        <th scope="col">{{ __('tasks.Executor') }}</th>
                        <th scope="col">{{ __('tasks.Date of creation') }}</th>
                        @if(Auth::check())
                        <th scope="col">{{ __('tasks.Actions') }}</th>
                        @endif
                    </tr>
                    @if ($tasks)
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td scope="row"> {{ $task->status->name }} </td>
                                <td><a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
                                <td>{{ $task->creator->name }}</td>
                                <td>{{ $task->executor->name ?? null }}</td>
                                <td>{{ $task->created_at->format('d.m.Y') }}</td>
                                @if(Auth::check())
                                <td>
                                    @can('delete', $task)
                                        <a class="text-danger" href="{{ route('tasks.destroy', ['task' => $task->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}">{{ __('tasks.Delete') }}</a>
                                    @endcan
                                    @can('update', $task)
                                    <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('tasks.Edit') }}</a>
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
@endsection