@extends('layouts.app')

@section('content')
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
                <a class="btn btn-primary float-right mb-3" href="{{ route('production.create') }}">{{ __('Add Production') }}</a>
                <div class="table-responsive">
                    <table id="tabulator" class="table table-light table-striped border rounded">
                        <thead>
                            <tr>
                                <th >{{ __('Code') }}</th>
                                <th >{{ __('Start date') }}</th>
                                <th >{{ __('End date') }}</th>
                                <th tabulator-formatter="html">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->token }}</td>
                                    <td>{{ $item->start_at }}</td>
                                    <td>{{ $item->end_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('production.show', $item->id) }}" class="btn btn-link">{{ __('View') }}</a>
                                            <a href="{{ route('production.edit', $item->id) }}" class="btn btn-link">{{ __('Edit') }}</a>

                                            <form action="{{ route('production.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link deleteOrder" type="submit">{{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.deleteOrder', function () {
            var answer = confirm("{{ __('Are you sure about deleting this order?') }}");

            if (!answer) {
                return false;
            }
        })
    </script>
@endpush
