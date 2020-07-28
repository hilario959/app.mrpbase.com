@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product Produced') }}
                    <a class="float-right" href="{{ route('production.index') }}">{{ __('Back') }}</a>
                </div>
                <div>
                  <a href="edit2" class="btn btn-primary btn-sm" style="margin: 10px;">Product View</a>
                </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                        @endif 
                       <div class="col-md-12">
            <h3 class="my-3">{{ __('Product Produced') }}</h3>
             
            <div class="table-responsive">
                <table class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <td>{{ __('Product Name') }}</td>                           
                            <td>{{ __('Item Produced') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($production as $productions)
                        <tr>
                            <td>{{$productions->name}}</td>
                            <td>{{$productions->to_be_produced}}</td>    
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection