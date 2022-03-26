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
                            <h2 class="content-header-title float-start mb-0">{{trans('blogs.blogs')}} Hello {{get_auth_username()}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row" id="table-hover-animation">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('blogs.blogs')}}</h4>
                            </div>
                            <div class="row">
                                <form action="{{route('admin.blogs.index')}}" name="per_page_form">
                                    <select id="per_page" name="per_page">
                                        <option  @if(request()->per_page  == 3) selected @endif>3</option>
                                        <option  @if(request()->per_page  == 5) selected @endif>5</option>
                                        <option  @if(request()->per_page  == 10) selected @endif>10</option>

                                    </select>
                                </form>

                                <form method="get" action="{{route('admin.blogs.index')}}">
                                    <input type="search" name="search_text"/>
                                    <input type="submit" value="search"/>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover-animation">
                                    <thead>
                                    <tr>
                                        <th>{{__('User ID')}}</th>
                                        <th>{{trans('blogs.title')}}</th>
                                        <th>{{__('blogs.author')}}</th>
                                        <th>{{trans('blogs.date')}}</th>
                                        <th>{{__('blogs.actions.title')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($blogs)>0)
                                    @foreach($blogs as $blog)
                                        <tr @if($blog->trashed())) style="background-color: #ea5455" @endif>
                                            <td>
                                                <span class="fw-bold">{{$blog->id}}</span>
                                            </td>
                                            <td>{{$blog->title}}</td>
                                            <td>
                                                {!! optional($blog->author)->name ?? "<span style='color:red;'>No author</span>" !!}
                                            </td>
                                            <td>{{$blog->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{route('admin.blogs.edit',$blog->id)}}">
                                                            <i data-feather="edit-2" class="me-50"></i>
                                                            <span>Edit</span>
                                                        </a>
            <span class="dropdown-item delete" data-url="{{route('admin.blogs.delete',$blog->id)}}">
                <i data-feather="trash" class="me-50"></i>
                <span>Delete</span>
            </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">لا توجد أي مقالات</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#per_page').on('change', function() {
                document.forms["per_page_form"].submit();
            });

            $('.delete').on('click',function (){
                var this_btn = $(this);
                var url = this_btn.attr('data-url');
                var token = $('input[name=_token]').val();
                // var base_url = window.location.origin; // http://127.0.0.1:8000
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: token,
                    },
                    success: function(data) {
                        if(data.success){
                            if(data.type === 'soft'){
                                this_btn.closest('tr').css("background-color",'#ea5455');
                            }else {
                                this_btn.closest('tr').remove();
                            }
                        }else {
                            alert(data.error);
                        }
                    },
                    error:function (){
                        alert("error");
                    }

                });
            });
        });

    </script>
@endsection
