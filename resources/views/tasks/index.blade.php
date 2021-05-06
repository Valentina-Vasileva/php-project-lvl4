@extends('layouts.app')

@section('content')
<div class="container">
    @include('flash::message')
    <h1 class="mb-5">{{ __('Tasks') }}</h1>
    @if(Auth::check())
    <div class="row">
        <div class="col my-2">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">{{ __('Create task') }}</a>
        </div>
    </div>
    @endif
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
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->creator->name }}</td>
                                <td>{{ $task->executor->name ?? null }}</td>
                                <td>{{ $task->created_at }}</td>
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