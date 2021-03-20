@extends('lean::layout')

@section('content')
    <div class="w-full h-screen flex justify-center">
        <div class="text-2xl mt-16">
            Resource <code class="text-brand-100 bg-brand-900 px-1 rounded">{{ $resource }}</code> not found.
        </div>
    </div>
@endsection
