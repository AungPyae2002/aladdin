@extends('admin.layout.app')
@section('content')
    <div class="content pt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card b-radius--10">
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Image
                                    <b>
                                        <img src="{{asset($agent->image)}}" width="200px" alt="">
                                    </b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Name
                                    <b><p class="mb-0">{{$agent->name}}</p></b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Phone
                                    <b><p class="mb-0">{{$agent->phone}}</p></b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Contact Phone
                                    <b><p class="mb-0">{{$agent->contact}}</p></b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    NRC
                                    <b>
                                        <img src="{{asset($agent->nrc_front)}}" width="200px" alt="">
                                        <img src="{{asset($agent->nrc_back)}}" width="200px" alt="">
                                    </b>
                                </li>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Has Level 2 Account
                                    <b><p class="mb-0">{{$agent->has_level2_account ? 'Yes' : 'No'}}</p></b>
                                </li>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Submitted At
                                    <b><p class="mb-0">{{$agent->created_at->diffForHumans()}}</p></b>
                                </li>
                            </ul>
                            
                            <div class="d-flex flex-wrap justify-content-end mt-3">
                                <button class="btn btn-outline-secondary mr-3 confirmationBtn" data-question="Are you sure to reject this documents?" data-action="http://localhost/Test/MineLab%20v2.0%20Nulled/Files/admin/users/kyc-reject/2"><i class="las la-ban"></i>Cancel</button>
                                <form method="POST" action="{{route('admin.agent.approve',$agent->id)}}">
                                    @csrf
                                    <button class="btn btn-success"><i class="las la-check"></i>Approve</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
</div>
@endsection