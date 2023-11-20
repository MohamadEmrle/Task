@extends('site.layout.main')
@section('site_content')
    @foreach ($categories as $category )
        <div class="item"><img src="{{ asset('dist/images/categories/'.$category->image) }}"></div>
    @endforeach
@endsection
