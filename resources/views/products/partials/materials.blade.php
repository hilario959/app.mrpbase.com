<div class="well clearfix mb-2 pull-right">
    <a class="btn btn-success text-white" id="addRecord">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>{{ __('Material') }}</th>
            <th>{{ __('Quantity') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody id="materialsRepeaterContainer">
        @include('products.partials.materials_repeater', [
            'item' => optional(), 'k' => '%i%', 'placeholder' => true
        ])

        @isset($product)
            @foreach ($product->materials as $k => $item)
                @include('products.partials.materials_repeater')
            @endforeach
        @endif
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $(document).on('click', '#addRecord', function (e) {
            e.preventDefault();

            addMaterial();
        })

        $(document).on('click', '.deleteRecord', function (e) {
            e.preventDefault();

            removeMaterial($(this));
        });
    });

    function addMaterial () {
        var container = $(document).find('#materialsRepeaterContainer'),
            placeholder = $(document).find('#materialsRepeaterPlaceholder').clone();

        var ids = $.map(container.find('tr'), function (el, i) {
                console.log($(el).data('id'));
                return parseInt($(el).data('id')) || 0;
            }),
            maxId = Math.max.apply(null, ids) + 1;

        placeholder.data('id', maxId);
        placeholder.html(placeholder.html().replaceAll('%i%', maxId));
        placeholder.find('input, select').removeAttr('disabled')
        placeholder.show()
        container.append(placeholder);
    }

    function removeMaterial ($this) {
        $this.parents('tr').remove();
    }
</script>
