@extends('layouts.app')

@section('content')
<div class="container">
        @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div> 
        @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- <input name="" id="" class="btn btn-primary" type="file" > -->
                    <form action="/home" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="fileToUpload[]" id="exampleInputFile" aria-describedby="fileHelp" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>File</th>
                                            <th>Size</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="txt-oflo">{{ $file }}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach

                    </table> 


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
