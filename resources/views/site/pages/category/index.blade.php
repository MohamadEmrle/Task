@extends('site.layout.main')
@section('site')
    <h1 id="servuces" class="main-heading">أعمالنا</h1>

    <div class="row">
        @foreach ($categories as $category)
        <div class="col-xs-12 col-sm-6 col-md-4 no-padding">
            <a href="{{ route('categories.show',$category->id) }}" class="img-holder">
                <img src="{{ asset('storage/images/categories/'.$category->image) }}" alt="...">

                <div class="hover-content">
                    <h1>اسم القسم</h1>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    </div>
</div>

@endsection
