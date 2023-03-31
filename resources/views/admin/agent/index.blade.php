@extends('admin.layout.app')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Agents</h1>
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
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Contact</th>
                        <th>Password</th>
                        <th>Approved At</th>
                        <th style="min-width: 100px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($agents as $index=>$agent)
                          <tr>
                              <td>{{$index+1}}</td>
                              <th>{{$agent->name}}</th>
                              <th>{{$agent->phone}}</th>
                              <th>{{$agent->contact}}</th>
                              <th>{{$agent->display_password}}</th>
                              <th>
                                {{$agent->approved_at->format('Y-m-d h:i A')}}
                              </th>
                              <th>{{$agent->created_at->diffForHumans()}}</th>
                              <th>
                                  <a 
                                    onclick="if(confirm('Are you sure you want to delete this?')){
                                        event.preventDefault();
                                        document.getElementById('type-delete-{{$agent->id}}').submit();
                                      }"
                                  type="button" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                  </a>

                                  <form id="type-delete-{{$agent->id}}" action="{{route('admin.agent.destroy',$agent->id)}}" method="POST">
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
                    Total  {{$agents->total()}}  Items
                  </div>
                  <div class="float-right">
                    {{$agents->appends(request()->all())->links()}}
                  </div>
                </div>
              </div>
            </div>

            

            
          </div>
            
        </div>
    </section>
@endsection