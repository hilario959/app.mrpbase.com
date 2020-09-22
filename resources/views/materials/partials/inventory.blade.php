<div class="card">
    <div class="card-body">
        <form method="post" action="{{ route('inventory.store', [$material->id]) }}">
            @csrf
            <div class="row form-group">
                <div class="col">
                    <div>
                        <label for="date_entry">{{ __('Date of Entry') }}</label>
                        <input type="date" class="form-control" name="date_entry"/>
                    </div>
                </div>
                <div class="col">
                    <label for="notes">{{ __('Quantity (In Kgs)') }}</label>
                    <input type="number" step="0.0001" class="form-control" name="quantity"/>
                </div>
            </div>
            <div class="form-group">
                <label for="notes">{{ __('Notes') }}</label>
                <input type="text" class="form-control" name="notes"/>
            </div>

            <div class="form-group">
                <h4>{{ __('Total') }}: {{ $material->amount }}</h4>
            </div>
            <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
        </form>
    </div>
</div>

<table id="tabulator" class="table table-light table-striped border rounded mt-4">
    <thead>
    <tr>
        <th >{{ __('Date of Entry') }}</th>
        <th >{{ __('Quantity') }}</th>
        <th >{{ __('Notes') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($material->inventory as $item)
        <tr>
            <td>{{ $item->date_entry }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->notes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
