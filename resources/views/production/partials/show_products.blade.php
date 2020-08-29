<div class="table-responsive">
    <table class="table table-light table-striped border rounded" id="tabulatorProducts">
        <thead>
            <tr>
                <th tabulator-formatter="html">{{ __('Product') }}</th>
                <th>{{ __('Quantity') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productionProducts as $item)
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

@push('scripts')
    <script>
        window.addEventListener("load", function () {
            if (document.getElementById('tabulatorProducts') != null) {
                var table = new Tabulator("#tabulatorProducts", {
                    layout:"fitColumns",
                    movableColumns:true,
                });
            }
        },false);
    </script>
@endpush
