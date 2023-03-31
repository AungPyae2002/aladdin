@extends('admin.layout.app')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Pending Agents</h1>
          </div><!-- /.col --><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content pt-3">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Contact</th>
                        <th>Created At</th>
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
                              <th>{{$agent->created_at->diffForHumans()}}</th>
                              <th>
                                  <a href="{{route('admin.agent.pending',$agent->id)}}" class="btn btn-sm btn-info">
                                      <i class="fas fa-eye"></i>View Details
                                  </a>
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