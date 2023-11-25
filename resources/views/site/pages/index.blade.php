@extends('site.layout.main')
@section('site_content')
    @foreach ($categories as $category )
        <div class="item" style="background-size: cover;">
            <img src="{{ asset('storage/images/categories/'.$category->image) }}">
        </div>
    @endforeach
@endsection
