<div class="modal fade" id="orderProductsModal{{ $order->id }}" data-id="{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ __('Produced products list for order ') }}
                    <b>#{{ $order->code }}</b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-light table-striped border rounded" id="orderProductsTable{{ $order->id }}">
                    <thead>
                        <tr>
                            <th tabulator-formatter="html">{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->productionProducts as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('product.edit', [$item->product->id]) }}" target="_blank">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
