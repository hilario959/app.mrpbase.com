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
            <h3 class="my-3">{{ __('Products') }}</h3>
            <a class="btn btn-link float-right" href="{{ route('product.create') }}">{{ __('Add Product') }}</a>
            <div class="table-responsive">
                <table id="tabulator" class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <th tabulator-headerFilter="true">{{ __('Name') }}</th>
                            <th tabulator-headerFilter="true">{{ __('Code') }}</th>
                            <th tabulator-headerFilter="true">{{ __('Description') }}</th>
                            <th colspan = 2 tabulator-formatter="html">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product as $products)
                        <tr>
                            <td>{{$products->name}}</td>
                            <td>{{$products->code}}</td>
                            <td>{{$products->description}}</td>
                            <td>
                                <a href="{{ route('product.edit',$products->id)}}" class="btn btn-link">{{ __('Edit') }}</a>
                            </td>
                            <td>
                                <form action="{{ route('product.destroy', $products->id)}}" method="post">
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