<form method="GET" action="" class="search-component" id="search-form-{{ $column }}">
    @foreach(request()->except($column, 'page') as $key => $val)
        @if(is_array($val))
            @foreach($val as $v)
                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
    @endforeach

    <div class="input-group">
        <input type="text"
               name="{{ $column }}"
               class="form-control input-sm search-input"
               placeholder="{{ $placeholder }}"
               value="{{ $value }}"
               data-column="{{ $column }}"
               autocomplete="off"
        >
        @if($value)
            <a href="{{ url()->current() }}?{{ http_build_query(request()->except($column, 'page')) }}"
               class="btn btn-outline-secondary btn-sm pt-2"
               title="Reset">
                <i class="bi bi-x-octagon-fill mt-2"></i>
            </a>
        @endif
    </div>
</form>
