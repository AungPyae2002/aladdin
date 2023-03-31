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
                  <h1 class="card-title">Edit Payment Method</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.payment_method.update',$payment->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <input required id="image" name="image" type="file" class="form-control @error('image') is-invalid @enderror" placeholder="Enter image" value="{{old('image') ?? $payment->image}}">
                                    @error('image')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <img src="{{asset($payment->image)}}" width="100px" alt="">
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <input required id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" value="{{old('name') ?? $payment->name}}">
                                    @error('name')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group" style="margin-top: 30px">
                            <button class="btn btn-success btn-sm" type="submit">Submit</button>
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