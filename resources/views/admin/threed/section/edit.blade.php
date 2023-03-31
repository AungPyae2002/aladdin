@extends('admin.layout.app')
@push('css')
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endpush
@section('content')
    <div class="content pt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Edit Section</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.threed_section.update',$section->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row">

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                            <label for="opening_date_time">Opening Date Time</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input readonly id="opening_date_time" name="opening_date_time"  type="text" class="form-control @error('opening_date_time') is-invalid @enderror" value="{{Carbon\Carbon::parse($section->opening_date_time)->format('Y-m-d H:i A')}}">
                                @error('opening_date_time')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                            <label for="ending_minute">Ending Minute (before opening time)</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input required id="ending_minute" name="ending_minute" type="number" class="form-control @error('ending_minute') is-invalid @enderror" value="{{old('ending_minute') ?? $section->ending_minute}}" placeholder="15">
                                @error('ending_minute')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="minimum_amount">Minimum Amount(default)</label>
                                <div class="mr-1" style="flex-grow: 1">
                                    <input id="minimum_amount" name="minimum_amount" type="number" class="form-control @error('minimum_amount') is-invalid @enderror" placeholder="Enter minimum_amount" value="{{old('minimum_amount') ??  $section->minimum_amount}}">
                                    @error('minimum_amount')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="maximum_amount">Maximum Amount(default)</label>
                                <div class="mr-1" style="flex-grow: 1">
                                    <input id="maximum_amount" name="maximum_amount" type="number" class="form-control @error('maximum_amount') is-invalid @enderror" placeholder="Enter maximum_amount" value="{{old('maximum_amount') ??  $section->maximum_amount}}">
                                    @error('maximum_amount')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="multiply">Multiply</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <input required id="multiply" name="multiply" type="number" class="form-control @error('multiply') is-invalid @enderror" placeholder="Enter commision percent" value="{{old('multiply') ?? $section->multiply}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">z</span>
                                    </div>
                                    @error('multiply')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="winning_number">Winning Number</label>
                                <div class="mr-1" style="flex-grow: 1">
                                    <input id="winning_number" name="winning_number" type="number" class="form-control @error('winning_number') is-invalid @enderror" placeholder="Enter winning number" value="{{old('winning_number') ??  $section->winning_number}}">
                                    @error('winning_number')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12 d-flex">
                            <button class="ml-auto btn btn-success btn-sm px-4" type="submit">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <form action="{{route("admin.threed_section.number.update",$section->id)}}" method="POST">
                    @csrf
                    <div class="card-header">
                        Numbers (Limit amount)
                    </div>
                     <div class="card-body">
                        <table class="table">
                                <tr>
                                    <th>Number</th>
                                    <th>Current Betting Amount</th>
                                    <th>Current Percent</th>
                                    <th>Maximum Amount</th>
                                </tr>
                                @foreach (json_decode($section->numbers_info) as $key=>$number)
                                    <tr>
                                        <td>
                                            <label class="mb-0">{{$key}}</label>
                                        </td>
                                        <td>
                                            {{$section->getTotalAmount($key)}} Unit
                                        </td>
                                        <td>
                                            {{$section->getPercent($key)}}%
                                        </td>
                                        <td>
                                            <div class="input-group col-md-6">
                                                <input required type="text" name="maximum_amount[]" class="form-control ml-3" value="{{$number->maximum_amount}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Unit</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            
                            <div class="col-12 d-flex">
                                <button class="btn btn-success btn-sm px-4 ml-auto">Update</button>
                            </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#generatePassword').click(function(){
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                let counter = 0;
                while (counter < 8) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    counter += 1;
                }
                console.log(result)
                $('input[name="password"]').val(result)
            })
        })

        function copyToClipBoard(){
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($('input[name="password"]').val()).select();
                document.execCommand("copy");
                $temp.remove();
            }
    </script>
@endpush