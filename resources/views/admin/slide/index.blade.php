@extends('admin.layout.app')
@section('title')
    Slides
@endsection
@section('content')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Slides</h1>
          </div>
          <div class="col-sm-6">
            <div class="float-right">
                <a href="{{route('admin.slide.create')}}" class="btn btn-primary btn-sm">
                  Add new Slide
                </a>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <section class="content">
        <div class="container-fluid">

            <div class="row">
                @foreach ($slides as $slide)
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="">
                                <img src="{{$slide->image}}" style="width: 100%;aspect-ratio:7/2;object-fit:cover" alt="">
                            </div>
                            <div class="card-footer">
                              <div class="d-flex">
                                <h5>{{$slide->name}}</h5>
                                <div class="ml-auto">
                                  <a href="{{route('admin.slide.edit',$slide->id)}}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i>Edit
                                  </a>
                                   <a 
                                  onclick="if(confirm('Are you sure you want to delete this?')){
                                      event.preventDefault();
                                      document.getElementById('slide-delete-{{$slide->id}}').submit();
                                    }"
                                type="button" class="btn btn-sm btn-danger">
                                  <i class="fa fa-trash"></i>
                                  Delete
                                </a>

                                <form id="slide-delete-{{$slide->id}}" action="{{route('admin.slide.destroy',$slide->id)}}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                </form>

                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body px-5">
                            <form action="{{route('admin.home-banner-text.update')}}" method="POST">
                                @csrf
                                <div class="row align-items-center mb-4">
                                    <div class="col-md-4 text-left capitalize"> <b>Home Banner Text</b> </div>
                                    <div class="col-md-8 ml-auto text-center">
                                        <div class="form-group mb-0">
                                            <div class="input-group date" id="premium_duration" data-target-input="nearest">
                                                <textarea name="home_banner_text" type="text"  class="form-control datetimepicker-input" data-target="#premium_duration">{{$home_banner_text}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="float-left">
                    Total  {{$slides->total()}}  items
                  </div>
                <div class="float-right">
                  {{$slides->appends(request()->all())->links()}}
                </div>
            </div>
        </div>
    </section>
@endsection