@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">  
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}  
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <h3 class="my-3">{{ __('Orders') }}</h3>
            <a class="btn btn-link float-right" href="{{ route('order.create') }}">{{ __('Add Order') }}</a>
            <div class="table-responsive">
                <table class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <td>{{ __('Code') }}</td>
                            <td>{{ __('Client') }}</td>
                            <td>{{ __('Delivery date') }}</td>
                            <td colspan = 2>Actions</td> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order as $orders)
                        <tr>
                            <td>{{$orders->code}}</td>
                            <td>{{$orders->client->first_name}}</td>
                            <td>{{$orders->delivery_date}}</td>
                            <td>
                                <a href="{{ route('order.edit',$orders->id)}}" class="btn btn-link">{{ __('Edit') }}</a>
                            </td>
                            <td>
                                <form action="{{ route('order.destroy', $orders->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link" type="submit">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection