@extends('site.layout.main')

@section('site')

    <h1 id="servuces" class="main-heading">خدماتنا</h1>
    @foreach ($services as $service )
        <h1><strong>{{ $service->name }}</strong></h1>
        <h2>{{ $service->description }}</h2>
        <hr>
    @endforeach
@endsection
