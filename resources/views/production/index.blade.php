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
            <h3 class="my-3">{{ __('Production') }}</h3>
            <a class="btn btn-link float-right" href="{{ route('production.create') }}">{{ __('Add Production') }}</a>
            <div class="table-responsive">
                <table class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <td>{{ __('ID') }}</td>
                            <td>{{ __('Created') }}</td>                           
                            <td colspan = 2>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($production as $productions)
                        <tr>
                            <td>{{$productions->id}}</td>
                            <td>{{$productions->created_at}}</td>                           
                            <td>
                                <a href="{{ route('production.edit',$productions->unique_id)}}" class="btn btn-link">{{ __('View') }}</a>
                            </td>
                            <td>
                                <form action="{{ route('production.destroy', $productions->unique_id)}}" method="post">
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