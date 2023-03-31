@extends('admin.layout.app')
@push('css')
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endpush
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            @foreach ($sections as $key => $schedules)
            <div class="card">
                <div class="card-header">
                  <h1 class="card-title"><b>{{$key}}</b></h1>
                </div>
                <div class="card-body py-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="" style="width: 10px">#</th>
                        <th class="">Opening Date Time</th>
                        <th class="">Ending Time</th>
                        <th>Amount</th>
                        <th class="">Winnning Number</th>
                        <th class="" style="min-width: 100px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($schedules as $index=>$schedule)
                          <tr>
                              <td class="">{{$index+1}}</td>
                              <td class="pb-0">{{Carbon\Carbon::parse($schedule->opening_date_time)->format('Y-m-d h:i A')}} ({{$schedule->multiply}}z)</td>
                              <td class="pb-0">
                                {{Carbon\Carbon::parse($schedule->opening_date_time)->subMinutes($schedule->ending_minute)->format('Y-m-d h:i A')}}
                                <b>({{$schedule->ending_minute}} Minutes)</b>
                              </td>

                              <td class="pb-0">
                                @if($schedule->minimum_amount) Min : {{$schedule->minimum_amount}} , @endif @if($schedule->maximum_amount) Max :  {{$schedule->maximum_amount}}  @endif
                              </td>
                              <td class="pb-0">{{$schedule->winning_number}}</td>

                              <td class="pb-0">
                                  <a href="{{route('admin.threed_section.edit',$schedule->id)}}" class="btn btn-sm btn-info">
                                      <i class="fas fa-edit"></i>Edit
                                  </a>
                                  <a 
                                    onclick="if(confirm('Are you sure you want to delete?')){
                                        event.preventDefault();
                                        document.getElementById('type-delete-{{$schedule->id}}').submit();
                                      }"
                                  type="button" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                  </a>

                                  <form id="type-delete-{{$schedule->id}}" action="{{route('admin.threed_section.destroy',$schedule->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                  </form>
                              </td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            @endforeach
            
        </div>

        {{-- <div class="card-footer">
            <div class="float-left">
            {{__('pagination.total')}}  {{$types->total()}}  {{__('pagination.items')}}
            </div>
            <div class="float-right">
            {{$types->appends(request()->all())->links()}}
            </div>
        </div> --}}
    </section>
@endsection