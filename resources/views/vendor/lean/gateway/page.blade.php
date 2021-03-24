@extends('lean::layout')

@section('content')

{{-- todo more systematic keys (& consistent everywhere), e.g. _lean-main-page --}}
{{-- todo action, type being 'show' to not have those unsaved modals --}}
@livewire($action, $data, key('main-lean-page'))

@endsection
