<div {!! $table->getSearchContainerAtts() !!}>
    <input {!! $table->getSearchInputAtts() !!}>

    <button {!! $table->getSearchButtonAtts() !!}>
        {!! $table->getSearchIconHtml() !!}
    </button>

    <form style="display: none;" method="get" larables-id="search-form">
        @foreach ($table->getArgsForSearchRequest() as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</div>