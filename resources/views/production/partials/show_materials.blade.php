<div class="table-responsive">
    <table class="table table-light table-striped border rounded" id="tabulatorMaterials">
        <thead>
            <tr>
                <th tabulator-formatter="html">{{ __('Material') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Remaining') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventory as $item)
                <tr>
                    <td>
                        <a href="{{ route('material.edit', [$item->material_id]) }}" target="_blank">
                            {{ $item->material->name }}
                        </a>
                    </td>
                    <td>{{ $item->quantity * -1 }}</td>
                    <td>{{ $item->material->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
    <script>
        window.addEventListener("load", function () {
            if (document.getElementById('tabulatorMaterials') != null) {
                var table = new Tabulator("#tabulatorMaterials", {
                    layout:"fitColumns",
                    movableColumns:true,
                });
            }
        },false);
    </script>
@endpush
