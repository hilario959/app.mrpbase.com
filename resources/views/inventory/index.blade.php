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
            <h3 class="my-3">{{ __('Inventory') }}</h3>
            <a class="btn btn-link float-right" href="{{ route('inventory.create') }}">{{ __('Add Inventory') }}</a>
            <div class="table-responsive">
                <table id="tabulator" class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <th >{{ __('Date of Entry') }}</th>
                            <th >{{ __('Name') }}</th>
                            <th >{{ __('Quantity') }}</th>
                            <th tabulator-formatter="html">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory as $inventories)
                        <tr>
                            <td>{{$inventories->date_entry}}</td>
                            <td>{{$inventories->material_id}}</td>
                            <td>{{$inventories->quantity}}</td>
                            <td>
                             <form action="{{ route('inventory.destroy', $inventories->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('inventory.edit',$inventories->id)}}" class="btn btn-link">{{ __('Edit') }}</a>
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
