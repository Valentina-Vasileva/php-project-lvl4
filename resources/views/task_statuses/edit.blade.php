@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Изменение статуса</h1>
    <div class="row">
        <div class="col">
            {{Form::model($taskStatus, ['url' => route('task_statuses.update', ['task_status' => $taskStatus]), 'method' => 'PATCH'])}}
                {{Form::text('name')}}
                @if ($errors->any())
                    <div class="invalis-feedback">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                {{Form::submit('Изменить')}}
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection