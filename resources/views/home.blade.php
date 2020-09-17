@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold">{{ __('Orders Received') }} </h4>
                    <p class="card-text text-primary">
                        <i class="fas fa-angle-double-down fa-2x"></i>
                        <span class="ml-2" style="font-size: 30px;">{{ $ordersReceived }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold">{{ __('Orders In Progress') }} </h4>
                    <p class="card-text text-warning">
                        <i class="fas fa-spinner fa-2x"></i>
                        <span class="ml-2" style="font-size: 30px;">{{ $ordersInProgress }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold">{{ __('Orders Done') }} </h4>
                    <p class="card-text text-success">
                        <i class="fas fa-check fa-2x"></i>
                        <span class="ml-2" style="font-size: 30px;">{{ $ordersDone }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 mt-2">
            <h3 class="font-weight-bold">{{ __('Remaining Materials') }}</h3>
            <table id="tabulator" class="table table-light table-striped border rounded">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th tabulator-formatter="html">{{ __('Quantity (In Kgs)') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <td>{{ $material->name }}</td>
                            <td>
                                <span class="
                                    font-weight-bold
                                    @if ($material->amount < 0)
                                        text-danger
                                    @elseif ($material->amount > 0)
                                        text-success
                                    @else
                                        text-warning
                                    @endif
                                ">
                                    {{ $material->amount }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
    </div>
</div>
@endsection
