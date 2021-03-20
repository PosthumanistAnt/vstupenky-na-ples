@extends('lean::layout')

@section('content')
    <div class="w-full h-screen flex justify-center">
        <div class="text-2xl mt-16">
            Page <code class="text-brand-100 bg-brand-900 px-1 rounded">{{ $page }}</code> not found.
        </div>
    </div>
@endsection
