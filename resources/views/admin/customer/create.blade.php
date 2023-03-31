@extends('admin.layout.app')
@section('content')
    <div class="content pt-3">
        <div class="container-fluid">
            <div class="col-md-6 mx-auto">
              <div class="card">
                <div class="card-header">
                  <h1 class="card-title">Register User</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.customer.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                            <label for="name">Name</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input required id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" value="{{old('name')}}">
                                @error('name')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                            <label for="phone">Phone</label>
                            <div class="mr-1" style="flex-grow: 1">
                                <input required id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone" value="{{old('phone')}}">
                                @error('phone')
                                    <span class="error invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                            <label for="password">Password</label>
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="mr-1" style="flex-grow: 1">
                                        <input required id="password" name="password" type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" value="{{old('password')}}">
                                        @error('password')
                                            <span class="error invalid-feedback">
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-sm btn-light px-3" onclick="copyToClipBoard()">Copy</button>
                                    <button type="button" class="btn btn-sm btn-light px-3" id="generatePassword">Generate</button>
                                </div>
                            </div>
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