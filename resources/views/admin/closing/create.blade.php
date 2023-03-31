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
                  <h1 class="card-title">Add Closing Day</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.closing-day.store')}}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <input required id="date" name="date" type="date" class="form-control @error('date') is-invalid @enderror" placeholder="Enter date" value="{{old('date')}}">
                                    @error('date')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <input required id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title" value="{{old('title')}}">
                                    @error('title')
                                        <span class="error invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                         <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <div class="mr-1 input-group" style="flex-grow: 1">
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description">{{old('description')}}</textarea>
                                    @error('description')
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