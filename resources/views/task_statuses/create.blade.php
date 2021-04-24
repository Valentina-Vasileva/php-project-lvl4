@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">Создать статус</h1>
    <div class="row">
        <div class="col">
            {{Form::open(['url' => route('task_statuses.store')])}}
            {{Form::label('name', 'Имя')}}
        </div>
    </div>
    <div class="row">
        <div class="col col-4">
            {{Form::text('name', '', array('class' => 'form-control'))}}
            @if ($errors->any())
                <div class="invalis-feedback">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            {{Form::submit('Создать', array('class' => 'btn btn-primary mt-3'))}}
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection