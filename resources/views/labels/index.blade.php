@extends('layouts.app')

@section('content')
<div class="container">
    @include('flash::message')
    <h1 class="mb-5">{{ __('Labels') }}</h1>
    @if(Auth::check())
    <div class="row">
        <div class="col my-2">
            <a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('Create label') }}</a>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">{{ __('Label name') }}</th>
                        <th scope="col">{{ __('Date of creation') }}</th>
                        @if(Auth::check())
                        <th scope="col">{{ __('Actions') }}</th>
                        @endif
                    </tr>
                    @if ($labels)
                        @foreach ($labels as $label)
                            <tr>
                                <td>{{ $label->id }}</td>
                                <td scope="row"> {{ $label->name }} </td>
                                <td>{{ $label->created_at }}</td>
                                @if(Auth::check())
                                <td>
                                    <a class="text-danger" href="{{ route('labels.destroy', ['label' => $label]) }}" data-method="delete" rel="nofollow" data-confirm="Вы уверены?">{{ __('Delete') }}</a>
                                    <a href="{{ route('labels.edit', ['label' => $label]) }}">{{ __('Edit') }}</a>
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
            {{ $labels->links() }}
        </div>
    </div>
</div>
@endsection