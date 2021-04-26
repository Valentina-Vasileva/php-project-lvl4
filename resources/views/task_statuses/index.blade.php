@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">Статусы</h1>
    @if(Auth::check())
    <div class="row">
        <div class="col my-2">
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Дата создания</th>
                        @if(Auth::check())
                        <th scope="col">Действия</th>
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
                                    <a class="text-danger" href="{{ route('task_statuses.destroy', ['task_status' => $status]) }}" data-method="delete" rel="nofollow" data-confirm="Вы уверены?">Удалить</a>
                                    <a href="{{ route('task_statuses.edit', ['task_status' => $status]) }}">Изменить</a>
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