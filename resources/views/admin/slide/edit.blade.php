@extends('admin.layout.app')
@section('title')
    Edit Slide
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-8 mx-auto pt-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h1 class="card-title">Edit Slide</h1>
                    </div>
                    <form action="{{route('admin.slide.update',$slide->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{$slide->image}}" id="image" data-image-holder="image" data-image-input="image_label" class="file-manager" data-default-img="{{asset($slide->image)}}" id="image" width="100%" height="300px"  alt="here" class="mb-4 img-fluid">
                            </div>
                            <label for="image">Image</label>
                            <div class="input-group form-group">
                                <input required type="file" id="image_label" class="form-control @error('image') is-invalid @enderror" value="{{$slide->image}}" name="image"
                                    aria-label="Image" aria-describedby="file-manager">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="file-manager">Select</button>
                                </div>
                                @error('image')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " value="{{old('name') ?? $slide->name}}">
                                @error('name')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sort">Sort</label>
                                <input type="number" name="sort" value="{{old('sort') ?? $slide->sort}}" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{route('admin.slide.index')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
        </div>
    </div>
@endsection