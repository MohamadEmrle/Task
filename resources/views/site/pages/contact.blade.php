@extends('site.layout.main')
@section('site')
    @if (Session::has('store'))
        <h1 id="servuces" class="main-heading">{{ Session::get('store') }}</h1>
    @else
        <h1 id="servuces" class="main-heading">تواصل معنا</h1>
    @endif
    <div class="col-xs-12 col-sm-12">
        <form method="POST" action="{{ route('site.contact.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <label for="name"> الأسم/الشركة</label>
                <input type="text" class="form-control" name="name" placeholder="الاسم / الشركة">
            </div>
            @error('name')
                <h3 class="alert alert-danger">{{ $message }}</h3>
            @enderror
            <div class="row">
                <label for="name">نوع النشاط</label>
                <input type="text" class="form-control" name="type" placeholder="نوع النشاط">
            </div>
            @error('type')
                <h3 class="alert alert-danger">{{ $message }}</h3>
            @enderror
            <div class="row">
                <label for="phone">رقم التواصل</label>
                <input type="tel" class="form-control" name="phone" placeholder="رقم التواصل">
            </div>
            @error('phone')
                <h3 class="alert alert-danger">{{ $message }}</h3>
            @enderror
            <div class="row">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني">
            </div>
            @error('email')
                <h3 class="alert alert-danger">{{ $message }}</h3>
            @enderror
            <div class="row">
                <label for="service_id">نوع الخدمة</label>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="box black-box margin-bottom">
                                <div class="main-label">
                                    <label class="checkbox-holder">
                                        <input type="radio" class="form-control" name="service_id"
                                            value="{{ $service->id }}">

                                        <span>{{ $service->name }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('service_id')
                    <h3 class="alert alert-danger">{{ $message }}</h3>
                @enderror
                <div class="row">
                    <label for="image">إرفاق ملف</label>
                    <input type="file" class="form-control" name="image" placeholder="إرفاق ملف">

                </div>
                @error('image')
                    <h3 class="alert alert-danger">{{ $message }}</h3>
                @enderror
                <div class="btn btn-white btn-block">
                    <span><input type="submit" value="إرسال"></span>
                </div>

        </form>
    </div>
@endsection
