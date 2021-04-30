@extends('layouts.app')

@section('content')
<div class="container">
    @include('flash::message')
    <h1 class="mb-5">{{ __('Statuses') }}</h1>
    @if(Auth::check())
    <div class="row">
        <div class="col my-2">
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('Create status') }}</a>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">{{ __('Status name') }}</th>
                        <th scope="col">{{ __('Date of creation') }}</th>
                        @if(Auth::check())
                        <th scope="col">{{ __('Actions') }}</th>
                        @endif
                    </tr>
                    @if ($taskStatuses)
                        @foreach ($taskStatuses as $status)
                            <tr>
                                <td>{{ $status->id }}</td>
                                <td scope="row"> {{ $status->name }} </td>
                                <td>{{ $status->created_at }}</td>
                                @if(Auth::check())
                                <td>
                                    <a class="text-danger" href="{{ route('task_statuses.destroy', ['task_status' => $status]) }}" data-method="delete" rel="nofollow" data-confirm="Вы уверены?">{{ __('Delete') }}</a>
                                    <a href="{{ route('task_statuses.edit', ['task_status' => $status]) }}">{{ __('Edit') }}</a>
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
            {{ $taskStatuses->links() }}
        </div>
    </div>
</div>
@endsection