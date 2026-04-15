<thead {!! $table->getTheadAtts() !!}>
    <tr {!! $table->getTheadTrAtts() !!}>
        @foreach ($table->getColumns() as $columnId => $title)
            <th {!! $table->getTheadThAtts($columnId, $loop->iteration) !!}>
                <div {!! $table->getColumnTitleContainerAtts() !!}>
                    <div {!! $table->getColumnTitleAtts() !!}>
                        {!! $table->getTitleForColumn($columnId, $title, $loop->iteration, 'head') !!}
                    </div>
                    @if ($table->isColumnSortable($columnId))
                        <button {!! $table->getSortButtonAtts() !!}>
                            @if ($table->getColumnOrderValue($columnId) == 'asc')
                                {!! $table->getDescSortIconHtml() !!}
                            @else
                                {!! $table->getAscSortIconHtml() !!}
                            @endif
                        </button>
                    @endif
                    <form style="display: none;" method="get">
                        @foreach ($table->getArgsForSortRequest($columnId) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </form>
                </div>
            </th>
        @endforeach
    </tr>
</thead>