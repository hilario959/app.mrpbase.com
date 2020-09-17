@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" id="productionForm" action="{{ route('production.store') }}">
            @csrf

            <input name="timezone" hidden value="">

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
                            <label for="start_at">{{ __('Start Date') }}</label>
                            <div class="input-group datetimepicker datetimepicker-input" id="dt1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#dt1"
                                       name="start_at" id="start_at" required
                                       value="{{ old('start_at') }}"/>
                                <div class="input-group-append" data-target="#dt1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="end_at">{{ __('End Date') }}</label>
                            <div class="input-group datetimepicker datetimepicker-input" id="dt2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#dt2"
                                       name="end_at" id="end_at" required
                                       value="{{ old('end_at') }}"/>
                                <div class="input-group-append" data-target="#dt2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
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

                        @foreach($orderData as $k => $item)
                            <tr>
                                <td class="align-middle">
                                    <input type="hidden" name="products[{{ $k }}][product_id]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="products[{{ $k }}][order_id]" value="{{ $item->order_id }}">

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
                                    {{ $item->remaining_quantity }} / {{ $item->quantity }}
                                </td>

                                <td class="align-middle">
                                    <input type="number" step="0.1" min="0" max="{{ $item->remaining_quantity }}"
                                           data-product-id="{{ $item->product->id }}"
                                           class="form-control productionQuantity" autocomplete="off"
                                           name="products[{{ $k }}][quantity]" />
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
                                <td class="align-middle w-50">
                                    <div>{{ $item->product->name }}</div>
                                    <small>
                                        {{
                                            $item->product->materials->map(function ($material) {
                                                return $material->name . ' (' . $material->pivot->quantity . ')';
                                            })->implode(', ')
                                        }}
                                    </small>
                                </td>

                                <td class="align-middle w-50">
                                    <input class="total_{{ $item->product->id }} form-control productionQuantityTotal"
                                           data-product-id="{{ $item->product->id }}"
                                           data-materials='@json($item->product->materials->mapWithKeys(function ($item) {
                                                return [$item->id => ['quantity' => $item->pivot->quantity]];
                                           }))'
                                           value="0" type="text" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <table class="table table-light border rounded">
                        <tr>
                            <th>{{ __('Material') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                        @foreach($materials as $item)
                            <tr>
                                <td class="align-middle w-50">
                                    {{ $item->name }} ({{ $item->amount }})
                                </td>

                                <td class="align-middle w-50">
                                    <input class="total_material_{{ $item->id }} form-control materialQuantityTotal"
                                           data-material-id="{{ $item->id }}" value="0" type="text" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <button class="btn btn-success btn-lg float-right" type="submit" id="submit_btn" >{{ __('Add Production') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js" defer></script>

    <script defer>
        $(document).ready(function () {
            $('#dt1').datetimepicker({
            });
            $('#dt2').datetimepicker({
                useCurrent: false
            });
            $("#dt1").on("change.datetimepicker", function (e) {
                $('#dt2').datetimepicker('minDate', e.date);
            });
            $("#dt2").on("change.datetimepicker", function (e) {
                $('#dt1').datetimepicker('maxDate', e.date);
            });

            $('input[name="timezone"]').val(moment.tz.guess());

            $(document).on('change', '.productionQuantity', function () {
                const $input = $(this),
                    product_id = $(this).data('product-id');

                if (!$input.get(0).checkValidity()) {
                    $input.get(0).reportValidity();
                    return;
                }

                let quantity = 0,
                    materials = {};

                $(`.productionQuantity[data-product-id="${product_id}"]`).each((i, el) => {
                    quantity += parseFloat($(el).val() || 0);
                })

                $(`.productionQuantityTotal[data-product-id="${product_id}"]`).val(quantity);

                $('.productionQuantityTotal').each((i, el) => {
                    const $el = $(el),
                        productQuantity = parseFloat($el.val() || 0),
                        productMaterials = $el.data('materials');

                    Object.keys(productMaterials).forEach((key) => {
                        materials[key] = (materials[key] || 0) + (productMaterials[key]['quantity'] * productQuantity)
                    });
                })

                Object.keys(materials).forEach((key) => {
                    $(`.materialQuantityTotal[data-material-id="${key}"]`).val(parseInt(materials[key]));
                })
            })
        });
    </script>
@endpush
