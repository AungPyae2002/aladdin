@extends('admin.layout.app')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Closing Days</h1>
          </div><!-- /.col --><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content pt-3">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                    <a href="{{route('admin.closing-day.create')}}" class="btn btn-sm btn-success">
                      <i class="fas fa-plus"></i>
                      Add new
                    </a>
                    <div class="card-tools">
                      <form action="{{route('admin.closing-day.index')}}" class="input-group input-group-sm" method="GET" style="width: 200px;">
                        <input type="text" name="search" value="" class="form-control float-right" placeholder="{{__('index.search')}}">

                        <div class="input-group-append">
                          <button type="submit" class="btn btn-success">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </form>
                    </div>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th style="min-width: 100px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($closingDays as $index=>$closingDay)
                          <tr>
                              <td>{{$index+1}}</td>
                              <th>{{$closingDay->date}}</th>
                              <th>{{$closingDay->title}}</th>
                              <th>{{$closingDay->description}}</th>
                              <th>{{$closingDay->created_at->diffForHumans()}}</th>
                              <th>
                                  <a href="{{route('admin.closing-day.edit',$closingDay->id)}}" class="btn btn-sm btn-info">
                                      <i class="fas fa-edit"></i>Edit
                                  </a>
                                  <a 
                                    onclick="if(confirm('Are you sure you want to delete this?')){
                                        event.preventDefault();
                                        document.getElementById('type-delete-{{$closingDay->id}}').submit();
                                      }"
                                  type="button" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                  </a>

                                  <form id="type-delete-{{$closingDay->id}}" action="{{route('admin.closing-day.destroy',$closingDay->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                  </form>
                              </th>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="float-left">
                    Total  {{$closingDays->total()}}  Items
                  </div>
                  <div class="float-right">
                    {{$closingDays->appends(request()->all())->links()}}
                  </div>
                </div>
              </div>
            </div>

            

            
          </div>
            
        </div>
    </section>
@endsection