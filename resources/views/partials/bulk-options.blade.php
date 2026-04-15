<div {!! $table->getBulkOptionsContainerAtts() !!}>    

    <select {!! $table->getBulkOptionsSelectAtts() !!}>
        <option value="">Select Option</option>

        @foreach ($table->getBulkOptions() as $option)
            <option {!! $table->parseAttributesToSTring($option) !!}>
                {{ $option['title'] }}
            </option>
        @endforeach
    </select>

    {{-- The form method and action would be added by javascript based on the
    request type and request route for the selected bulk option --}}
    <form style="display: none;" larables-id="bulk-options-form">
        <input type="hidden" larables-id="bulk-options-csrf-token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" larables-id="bulk-options-method" name="_method" value="">
        <input type="hidden" larables-id="bulk-options-name" name="{{ $table->getBulkActionKey() }}" value=""> 

        @foreach ($table->getArgsForBulkOptionsRequest() as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</div>