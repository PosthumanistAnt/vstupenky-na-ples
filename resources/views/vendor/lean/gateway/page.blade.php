@extends('lean::layout')

@section('content')

{{-- todo more systematic keys (& consistent everywhere), e.g. _lean-main-page --}}
@livewire($action, $data, key('main-lean-page'))

@endsection
