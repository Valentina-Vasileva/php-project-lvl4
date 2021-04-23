@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Создать статус</h1>
    <div class="row">
        <div class="col">
            {{Form::open(['url' => route('task_statuses.store')])}}
                {{Form::text('name')}}
                {{Form::submit('Создать')}}
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection