<tr {{ isset($placeholder) ? "id=materialsRepeaterPlaceholder style=display:none;" : '' }} data-id="{{ $item->id ?? $k }}">
    <td class="align-middle">
        <select class="form-control" name="materials[{{ $item->id ?? $k }}][id]" {{ isset($placeholder) ? 'disabled' : '' }}>
            @empty($item->name)
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">
                        {{ $material->name }} ({{ $material->amount }})
                    </option>
                @endforeach
            @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endempty
        </select>
    </td>
    <td class="align-middle">
        <input type="number" class="form-control"
               name="materials[{{ $item->id ?? $k }}][quantity]"
               value="{{ $item->pivot->quantity ?? 0 }}" {{ isset($placeholder) ? 'disabled' : '' }}>
    </td>
    <td class="align-middle">
        <a class="btn btn-danger deleteRecord text-white"><i class="fa fa-minus" aria-hidden="true"></i></a>
    </td>
</tr>
