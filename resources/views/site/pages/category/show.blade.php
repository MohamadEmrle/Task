@extends('site.layout.main')
@section('site')

        @if(count($records) != 0)


        <h1 id="servuces" class="main-heading">{{ $records[0]->category->name }}</h1>

        <div class="row">
            @foreach ($records as $record )
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <a class="fancybox-buttons img-holder small-img" rel="gallery" title="" data-fancybox-group="button" href="#">
                    <img src="{{ asset('storage/images/categories/'.$record->category->id.'/'.$record->image) }}" alt="img">
                </a>
            </div>
            @endforeach
            @else
            <br><br><br><br>
            <h1 id="servuces" class="main-heading">No Image</h1>
        </div>

    </div>

</div>

@endif
@endsection
