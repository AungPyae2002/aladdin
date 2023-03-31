@extends('admin.layout.app')
@push('css')
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endpush
@section('content')
    <div class="content pt-3">
        <div class="container-fluid">
            <div class="col-md-6 mx-auto">
              <div class="card">
                <div class="card-header">
                  <h1 class="card-title">Add New Schedule</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.threed_schedule.store')}}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                            <label for="opening_date">Opening Date (every month)</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input required id="opening_date" name="opening_date" type="number" class="form-control @error('opening_date') is-invalid @enderror" value="{{old('opening_date')}}" placeholder="16">
                                @error('opening_date')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                            <label for="opening_time">Opening Time</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input required id="opening_time" name="opening_time" type="time" class="form-control @error('opening_time') is-invalid @enderror" value="{{old('opening_time')}}" placeholder="16">
                                @error('opening_time')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="minimum_amount">Minimum Amount(default)</label>
                                <div class="mr-1" style="flex-grow: 1">
                                    <input id="minimum_amount" name="minimum_amount" type="number" class="form-control @error('minimum_amount') is-invalid @enderror" placeholder="Enter minimum_amount" value="{{old('minimum_amount')}}">
                                    @error('minimum_amount')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="maximum_amount">Maximum Amount(default)</label>
                                <div class="mr-1" style="flex-grow: 1">
                                    <input id="maximum_amount" name="maximum_amount" type="number" class="form-control @error('maximum_amount') is-invalid @enderror" placeholder="Enter maximum_amount" value="{{old('maximum_amount')}}">
                                    @error('maximum_amount')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="multiply">Multiply</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <input required id="multiply" name="multiply" type="number" class="form-control @error('multiply') is-invalid @enderror" placeholder="Enter multiply" value="{{old('multiply')}}">
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

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                            <label for="ending_minute">Ending Minute (before opening time)</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input required id="ending_minute" name="ending_minute" type="number" class="form-control @error('ending_minute') is-invalid @enderror" value="{{old('ending_minute')}}" placeholder="15">
                                @error('ending_minute')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="icheck-success d-inline">
                            <input name="is_auto" @if(old('is_auto') == "1") checked @endif value="1" type="checkbox" id="is_auto">
                            <label for="is_auto">
                                Is Auto
                            </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group" style="margin-top: 30px">
                            <button class="btn btn-success btn-sm" type="submit">Register</button>
                            </div>
                        </div>
                    </div>
                  </form>
                </div>
              </div>
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