@extends('layouts.admin.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">إضافة مدونة</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
                <!-- Basic Inputs start -->
                <section id="basic-input">
                    <form action="{{route('admin.blogs.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">إضافة مدونة جديدة</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="basicInput">عنوان المقالة</label>
                                                    <input type="text" required class="form-control" name="title" id="basicInput" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <textarea required name="text"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <select name="author_id" required>
                                                    <option value="" selected>اختر واحداً </option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <select name="categories[]" required multiple>
                                                    <option value="" selected>اختر من التصنيفات </option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <input type="submit" value="إنشاء" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </section>
                <!-- Basic Inputs end -->

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!-- BEGIN: Page Vendor JS-->

    <!-- END: Page Vendor JS-->
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'text' );

    </script>
    @endsection

