@extends('home')@section('content')
<div class="container">
    <div class="row">
    <a class="float-right" href="{{ route('production.index') }}">{{ __('Back') }}</a>
        <div class="col-md-12">
            <ul class="nav nav-tabs mb-5">
                <li class="nav-item">
                    <a class="nav-link active" href="edit">{{ __('Products Produced') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit2">{{ __('Orders Fulfilled') }}</a>
                </li>
            </ul>
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
                <div class="table-responsive">
                    <table class="table table-light table-striped border rounded">
                        <thead>
                            <tr>
                                <td>{{ __('Product') }}</td>                           
                                <td>{{ __('Quantity') }}</td>
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
@endsection