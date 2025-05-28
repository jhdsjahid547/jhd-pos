<form method="GET" action="{{ $routeName ? route($routeName) : url()->current() }}">
    @foreach(request()->query() as $key => $value)
        @if ($key !== 'page' && $key !== 'per_page')
            @if (is_array($value))
                @foreach($value as $arrayValue)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endif
    @endforeach

    <div class="input-group">
        <label class="input-group-text" for="per_page">Rows:</label>
        <select name="per_page" class="form-select" onchange="this.form.submit()">
            @foreach([10, 25, 50, 100] as $option)
                <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    </div>
</form>
