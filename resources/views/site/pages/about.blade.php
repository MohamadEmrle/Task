@extends('site.layout.main')
@section('site')
    <h1 id="servuces" class="main-heading">من نحن</h1>
    @foreach ($abouts as $about )
        <h2 ><p style="align-content: center">{{ $about->description }}</p></h2>
    @endforeach
    <div class="div-small-padding">
        <h1 id="servuces" class="main-heading">عملائنا</h1>
        <div class="row">
            <div class="col-xs-2 col-sm-1 no-padding text-center">
                <a class="owl-btn prev-pro margin"><span class="fa fa-angle-right"></span></a>
            </div>
        <div class="col-xs-8 col-sm-10 no-padding">
            <div id="owl-demo-products" class="owl-carousel-clients">
                @foreach ($customers as $customer )
                <div id="item" class="item">
                    <a class="fancybox-buttons" data-fancybox-group="button" href="images/logo-1.jpg">
                        <img src="{{ asset('storage/images/customers/'.$customer->image) }}" alt="img">
                    </a>
                    <h2>{{ $customer->name }}</h2>
                    <h4>{{ $customer->email }}</h4>
                </div>
                @endforeach

        </div>
    </div>
    <div class="col-xs-2 col-sm-1 no-padding text-center">
        <a class="owl-btn next-pro margin"><span class="fa fa-angle-left"></span></a>
    </div>
</div>
@endsection
