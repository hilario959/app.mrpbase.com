@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" id="productionForm" action="{{ route('production.update', [$production->id]) }}">
            @method('PUT')
            @csrf

            <div class="row">
                <div class="col-12 row">
                    <a class="btn btn-lg btn-link" href="{{ route('production.index') }}">< {{ __('Back') }}</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger ml-3 col-12">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif

                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col">
                            <label for="start_at">{{ __('Start date') }}</label>
                            <input type="datetime-local" name="start_at" class="form-control" id="start_at"
                                   value="{{ $production->start_at->format('Y-m-d\Th:i') }}" required>
                        </div>
                        <div class="col">
                            <label for="end_at">{{ __('End date') }}</label>
                            <input type="datetime-local" name="end_at" class="form-control" id="end_at"
                                   value="{{ $production->end_at->format('Y-m-d\Th:i') }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <table class="table table-light border rounded">
                        <tr>
                            <th class="pl-4">{{ __('Code') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Remaining') }}</th>
                            <th>{{ __('Production') }}</th>
                        </tr>

                        @foreach($productionData as $k => $item)
                            <tr>
                                <td class="align-middle">
                                    <input type="hidden" name="products[{{ $item->id }}][product_id]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="products[{{ $item->id }}][order_id]" value="{{ $item->order_id }}">

                                    <a href="{{ route('order.edit', ['order' => $item->order_id]) }}" target="_blank" class="btn btn-lg btn-link"
                                          title="{{ $item->order->client->first_name }} {{ $item->order->client->last_name }} {{ $item->order->delivery_date }}">
                                        {{ $item->order->code }}
                                    </a>
                                </td>

                                <td class="align-middle">
                                    <a href="{{ route('product.edit', ['product' => $item->product_id]) }}" target="_blank">
                                        {{ $item->product->name }}
                                    </a>
                                </td>

                                <td class="align-middle">
                                    {{ $item->product_remaining_quantity + $item->quantity }} / {{ $item->product_quantity }}
                                </td>

                                <td class="align-middle">
                                    <input type="number" step="0.1" min="0" max="{{ $item->product_remaining_quantity + $item->quantity }}"
                                           data-product-id="{{ $item->product->id }}"
                                           class="form-control productionQuantity" autocomplete="off"
                                           value="{{ $item->quantity }}"
                                           name="products[{{ $item->id }}][quantity]" />
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
                <div class="col-md-5">
                    <table class="table table-light border rounded">
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                        @foreach($productData as $item)
                            <tr>
                                <td class="align-middle">
                                    {{ $item->product->name }}
                                </td>

                                <td class="align-middle">
                                    <input class="total_{{ $item->product->id }} form-control productionQuantityTotal"
                                           data-product-id="{{ $item->product->id }}" value="0" type="text" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <button class="btn btn-success btn-lg float-right" type="submit" id="submit_btn" >{{ __('Edit Production') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
             $(document).on('change', '.productionQuantity', function () {
                 const $input = $(this);

                 computeProductsTotal($input);
             })

            $('.productionQuantity').each(function (i, el) {
                computeProductsTotal($(el))
            })

            function computeProductsTotal($input) {
                const product_id = $input.data('product-id');

                if (!$input.get(0).checkValidity()) {
                    $input.get(0).reportValidity();
                    return;
                }

                let quantity = 0;
                $(`.productionQuantity[data-product-id="${product_id}"]`).each(function (i, el) {
                    quantity += parseFloat($(el).val() || 0);
                })

                $(`.productionQuantityTotal[data-product-id="${product_id}"]`).val(quantity);
            }
        });
    </script>
@endpush
