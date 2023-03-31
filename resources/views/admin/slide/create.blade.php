@extends('admin.layout.app')
@section('title')
    Add new Slide
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-8 mx-auto pt-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h1 class="card-title">Add new Slide</h1>
                    </div>
                    <form action="{{route('admin.slide.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <label for="image">Image</label>
                            <div class="input-group form-group">
                                <input required type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                    aria-label="Image" aria-describedby="file-manager">
                                @error('image')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " value="{{old('name')}}">
                                @error('name')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sort">Sort</label>
                                <input type="number" name="sort" value="{{old('sort')}}" class="form-control">
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