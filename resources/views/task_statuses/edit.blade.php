@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('Status edit') }}</h1>
    <div class="row">
        <div class="col">
            {{Form::model($taskStatus, ['url' => route('task_statuses.update', ['task_status' => $taskStatus]), 'method' => 'PATCH'])}}
            <div class="form-row">
                <div class="col">
                    {{Form::label('name', __('Status name'))}}
                </div>
            </div>            
            <div class="form-row">
                <div class="col-4">
                    {{Form::text('name', $taskStatus->name, array('class' => 'form-control'))}}
                    @if ($errors->any())
                        <div class="invalis-feedback">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="col">             
                    {{Form::submit(__('Edit'), array('class' => 'btn btn-primary mt-3'))}}
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>
@endsection