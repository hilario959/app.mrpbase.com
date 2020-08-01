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
                <table id="tabulator" class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <th tabulator-headerFilter="true">{{ __('Code') }}</th>
                            <th tabulator-headerFilter="true">{{ __('Client') }}</th>
                            <th tabulator-headerFilter="true">{{ __('Delivery date') }}</th>
                            <th tabulator-formatter="html">Actions</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order as $orders)
                        <tr>
                            <td>{{$orders->code}}</td>
                            <td>{{$orders->client->first_name}}</td>
                            <td>{{$orders->delivery_date}}</td>
                            <td>
                              <form action="{{ route('order.destroy', $orders->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('order.edit',$orders->id)}}" class="btn btn-link">{{ __('Edit') }}</a>
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