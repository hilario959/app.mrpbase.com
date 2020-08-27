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
    <div class="col-md-12" >
      <h3 class="my-3">{{ __('Production') }}</h3>
      <a class="btn btn-link float-right" href="{{ route('production.create') }}">{{ __('Add Production') }}</a>
      <div class="table-responsive">
        <table id="tabulator" class="table table-light table-striped border rounded">
          <thead>
            <tr>
              <th >{{ __('Code') }}</th>
              <th >{{ __('Created') }}</th>
              <th tabulator-formatter="html">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($production as $productions)
            <tr>
              <td>PO-{{$productions->id}}</td>
              <td>{{$productions->created_at}}</td>
              <td>
                <form action="{{ route('production.destroy', $productions->unique_id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <a href="{{ route('production.edit',$productions->unique_id)}}" class="btn btn-link">{{ __('View') }}</a>
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

