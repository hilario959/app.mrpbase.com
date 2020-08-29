<div class="table-responsive">
    <table class="table table-light table-striped border rounded" id="tabulatorOrders">
        <thead>
        <tr>
            <th tabulator-formatter="html">{{ __('Order') }}</th>
            <th>{{ __('Client name') }}</th>
            <th>{{ __('Start production date') }}</th>
            <th>{{ __('End production date') }}</th>
            <th tabulator-formatter="html">{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $item)
            <tr>
                <td>
                    <a href="{{ route('order.edit', [$item->id]) }}" target="_blank">
                        {{ $item->code }}
                    </a>
                </td>
                <td>{{ $item->client->full_name }}</td>
                <td>{{ $production->start_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $production->end_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    <button class="btn btn-link" data-toggle="modal" data-target="#orderProductsModal{{ $item->id }}">
                        {{ __('View produced products') }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@foreach($orders as $order)
    @include('production.partials.order_produced_products')
@endforeach

@push('scripts')
    <script>
        window.addEventListener("load", function () {
            if (document.getElementById('tabulatorOrders') != null) {
                var table = new Tabulator("#tabulatorOrders", {
                    layout:"fitColumns",
                    movableColumns:true,
                });
            }
        },false);

        $(document).ready(function () {
            $(document).on('show.bs.modal', 'div[id^="orderProductsModal"]', function (e) {
                console.log('test');
                var id = $(this).data('id');

                if (!$(this).find('div.tabulator').length) {
                    console.log("test1");
                    var table = new Tabulator("#orderProductsTable" + id, {
                        layout:"fitColumns",
                        movableColumns:true,
                        initialSort:[
                            {column:"product", dir:"asc"},
                        ]
                    });
                }

            })
        })

    </script>
@endpush
