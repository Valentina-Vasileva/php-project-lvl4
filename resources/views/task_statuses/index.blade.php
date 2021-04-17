@extends('layouts.app')

@section('content')
<div class="container">
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
                                    <ul>
                                        <li><a href="{{ route('task_statuses.destroy', ['task_status' => $status]) }}" data-method="delete" rel="nofollow" data-confirm="Вы уверены?">Удалить</a></li>
                                        <li><a href="{{ route('task_statuses.edit', ['task_status' => $status]) }}">Редактировать</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection