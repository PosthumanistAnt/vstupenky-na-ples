@extends('lean::layout')

@section('content')

<div>
    @livewire($action, $data, key('main-lean-action'))
</div>

@endsection
