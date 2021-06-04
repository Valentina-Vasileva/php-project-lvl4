@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('Tasks') }}</h1>
    @if(Auth::check())
    <div class="row">
        <div class="col">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-2">{{ __('Create task') }}</a>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="d-flex">
                <div>
                    {{Form::open(['url' => route('tasks.index'), 'method' => 'GET', 'class' => 'form-inline'])}}
                    {{Form::select('filter[status_id]', $taskStatuses, $filter['status_id'] ?? null, array('placeholder' => __('Status'), 'class' => 'form-control my-2 mr-2'))}}
                    {{Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? null, array('placeholder' => __('Author'), 'class' => 'form-control my-2 mr-2'))}}
                    {{Form::select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ?? null, array('placeholder' => __('Executor'), 'class' => 'form-control my-2 mr-2'))}}
                    {{Form::submit(__('Apply'), array('class' => 'btn btn-outline-primary mr-2 my-2'))}}
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
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Task name') }}</th>
                        <th scope="col">{{ __('Author') }}</th>
                        <th scope="col">{{ __('Executor') }}</th>
                        <th scope="col">{{ __('Date of creation') }}</th>
                        @if(Auth::check())
                        <th scope="col">{{ __('Actions') }}</th>
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
                                        <a class="text-danger" href="{{ route('tasks.destroy', ['task' => $task->id]) }}" data-method="delete" rel="nofollow" data-confirm="Вы уверены?">{{ __('Delete') }}</a>
                                    @endcan
                                    @can('update', $task)
                                    <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('Edit') }}</a>
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