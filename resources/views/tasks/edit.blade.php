@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('Edit task') }}</h1>
    <div class="row">
        <div class="col">
            {{Form::model($task, ['url' => route('tasks.update', ['task' => $task]), 'method' => 'PATCH'])}}
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label('name', __('Task name'))}}
                        {{Form::text('name', $task->name, ['class' => 'form-control'])}}
                        @if ($errors->any())
                            <div class="invalid-feedback d-block">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label('description', __('Description'))}}
                        {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label('status_id', __('Status'))}}
                        {{Form::select('status_id', $taskStatuses, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
                        @if ($errors->any())
                        <div class="invalid-feedback d-block">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label('assigned_to_id', __('Executor'))}}
                        {{Form::select('assigned_to_id', $users, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label('label_id', __('Labels'))}}
                        {{Form::select('label_id', $labels, $task->labels, ['multiple' => 'multiple', 'name' => 'labels[]', 'class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    {{Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection