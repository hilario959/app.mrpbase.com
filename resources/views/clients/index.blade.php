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
            <h3 class="my-3">{{ __('Clients') }}</h3>
            <a class="btn btn-link float-right" href="{{ route('client.create') }}">{{ __('Add Client') }}</a>
            <div class="table-responsive">
                <table id="tabulator" class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <th >{{ __('Name') }}</th>
                            <th >{{ __('Company') }}</th>
                            <th >{{ __('Phone Number') }}</th>
                            <th >{{ __('E-Mail Address') }}</th>
                            <th tabulator-formatter="html">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client as $clients)
                        <tr>
                            <td>{{$clients->first_name}} {{$clients->last_name}}</td>
                            <td>{{$clients->company}}</td>
                            <td>{{$clients->number}}</td>
                            <td>{{$clients->email}}</td>
                            <td>
                              <form action="{{ route('client.destroy', $clients->id)}}" method="post">
                                @csrf
                                <a href="{{ route('client.edit',$clients->id)}}" class="btn btn-link">{{ __('Edit') }}</a>
                                <button class="btn btn-link" type="submit">{{ __('Delete') }}</button>
                                @method('DELETE')
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
