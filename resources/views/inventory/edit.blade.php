@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update an Inventory') }}
                    <a class="float-right" href="{{ route('inventory.index') }}">{{ __('Back') }}</a>
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
                        <form method="post" action="{{ route('inventory.update', $inventory->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="date_entry">{{ __('Date of Entry') }}</label>
                                <input type="date" class="form-control" name="name" value="{{ $inventory->date_entry }}" />
                            </div>
                            <div class="form-group">
                                <label for="material_id">{{ __('Client') }}</label>
                                <select class="advance-select-box form-control @error('material') is-invalid @enderror" id="material_id" name="material_id" required>
                                    <option value="" selected disabled>{{ __('Select a Client') }}</option>
                                    @foreach ($material as $materials)
                                        <option value="{{ $materials->id }}" @if($inventory->material_id == ($materials->id)) selected @endif> {{ $materials->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">{{ __('Quantity (In Kgs)') }}</label>
                                <input type="date" class="form-control" name="quantity" value="{{ $inventory->quantity }}" />
                            </div>
                            <div class="form-group">
                                <label for="notes">{{ __('notes') }}</label>
                                <input type="text" class="form-control" name="notes" value="{{ $inventory->notes }}" />
                            </div>


                            <button type="submit" class="btn btn-link">{{ __('Update Inventory') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
