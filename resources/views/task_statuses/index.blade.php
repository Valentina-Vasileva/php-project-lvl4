@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
                <table class="table table-responsive">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Дата создания</th>
                        <th scope="col">Действия</th>
                    </tr>
                    @if ($taskStatuses)
                        @foreach ($taskStatuses as $status)
                            <tr>
                                <td>{{ $status->id }}</td>
                                <td scope="row"> {{ $status->name }} </td>
                                <td>{{ $status->created_at }}</td>
                                <td>
                                    <a href="{{ route('task_statuses.destroy', ['task_status' => $status]) }}" data-method="delete" rel="nofollow" data-confirm="Вы уверены?">Удалить</a>
                                    <a href="{{ route('task_statuses.edit', ['task_status' => $status]) }}">Изменить</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection