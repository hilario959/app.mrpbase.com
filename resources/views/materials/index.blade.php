@extends('layouts.app')@section('content')
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
            <h3 class="my-3">{{ __('Materials') }}</h3>
            <a class="btn btn-link float-right" href="{{ route('material.create') }}">{{ __('Add Material') }}</a>
            <div class="table-responsive">
                <table id="tabulator" class="table table-light table-striped border rounded">
                    <thead>
                        <tr>
                            <th >{{ __('Name') }}</th>
                            <th >{{ __('Code') }}</th>
                            <th >{{ __('Description') }}</th>
                            <th tabulator-formatter="html">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($material as $materials)
                        <tr>
                            <td>{{$materials->name}}</td>
                            <td>{{$materials->code}}</td>
                            <td>{{$materials->description}}</td>
                            <td>
                              <form action="{{ route('material.destroy', $materials->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <span>
                                  <a href="{{ route('material.edit',$materials->id)}}" class="btn btn-link">{{ __('Edit') }}</a>
                                </span>

                                <span>
                                  <button class="btn btn-link" type="submit">{{ __('Delete') }}</button>
                                </span>
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
