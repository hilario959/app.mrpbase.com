@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update a Material') }}
                    <a class="float-right" href="{{ route('material.index') }}">{{ __('Back') }}</a>
                </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                        @endif
                        <form method="post" action="{{ route('material.update', $material->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $material->name }}" />
                            </div>
                            <div class="form-group">
                                <label for="code">{{ __('SKU') }}</label>
                                <input type="text" class="form-control" name="code" value="{{ $material->code }}" />
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <input type="text" class="form-control" name="description" value="{{ $material->description }}" />
                            </div>
                            <button type="submit" class="btn btn-link">{{ __('Update Material') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
