@extends('admin.layout.app')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Payment Methods</h1>
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
                    <a href="{{route('admin.payment_method.create')}}" class="btn btn-sm btn-success">
                      <i class="fas fa-plus"></i>
                      Add new
                    </a>
                    <div class="card-tools">
                      <form action="{{route('admin.payment_method.index')}}" class="input-group input-group-sm" method="GET" style="width: 200px;">
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
                        <th>Name</th>
                        <th>Created At</th>
                        <th style="min-width: 100px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($payments as $index=>$payment)
                          <tr>
                              <td>{{$index+1}}</td>
                              <td>
                                <img src="{{asset($payment->image)}}" width="100px" alt="">
                              </td>
                              <th>{{$payment->name}}</th>
                              <th>{{$payment->created_at->diffForHumans()}}</th>
                              <th>
                                  <a href="{{route('admin.payment_method.edit',$payment->id)}}" class="btn btn-sm btn-info">
                                      <i class="fas fa-edit"></i>Edit
                                  </a>
                                  <a 
                                    onclick="if(confirm('Are you sure you want to delete this?')){
                                        event.preventDefault();
                                        document.getElementById('type-delete-{{$payment->id}}').submit();
                                      }"
                                  type="button" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                  </a>

                                  <form id="type-delete-{{$payment->id}}" action="{{route('admin.payment_method.destroy',$payment->id)}}" method="POST">
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
                    Total  {{$payments->total()}}  Items
                  </div>
                  <div class="float-right">
                    {{$payments->appends(request()->all())->links()}}
                  </div>
                </div>
              </div>
            </div>

            

            
          </div>
            
        </div>
    </section>
@endsection