@extends('admin.layout.app')
@section('title')
    Setting
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1 class="m-0">Setting</h1> --}}
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
             <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h1 class="card-title">General Setting</h1>
                    </div>
                    <div class="card-body px-5">
                        <form action="{{route('admin.setting.update')}}" method="POST">
                            @csrf
                            @foreach ($settings as $key=>$setting)
                                <div class="row align-items-center mb-4">
                                    <div class="col-md-4 text-left capitalize"> <b>{{str_replace("_"," ",$key)}}</b> </div>
                                    <div class="col-md-8 ml-auto text-center">
                                        <div class="form-group mb-0">
                                            <div class="input-group date" id="premium_duration" data-target-input="nearest">
                                                <textarea name="{{$key}}" type="text"  class="form-control datetimepicker-input" data-target="#premium_duration">{{$setting}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>

           
            
        </div>
      </div>
    </section>
@endsection