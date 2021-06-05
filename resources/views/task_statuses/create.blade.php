@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('taskStatuses.Create status') }}</h1>
    <div class="row">
        <div class="col">
            {{Form::open(['url' => route('task_statuses.store')])}}
            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        {{Form::label('name', __('taskStatuses.Status name'))}}
                        {{Form::text('name', '', ['class' => 'form-control'])}}
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
                <div class="col">
                {{Form::submit(__('taskStatuses.Create'), ['class' => 'btn btn-primary mt-3'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection