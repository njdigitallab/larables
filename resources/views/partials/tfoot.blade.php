@if ($table->shouldDisplayTfoot())
    <tfoot {!! $table->getTfootAtts() !!}>
        <tr {!! $table->getTfootTrAtts() !!}>
            @foreach ($table->getColumns() as $columnId => $columnTitle)
                <th {!! $table->getTfootThAtts($columnId, $loop->iteration) !!}>
                    {!! $table->getTitleForColumn($columnId, $columnTitle, $loop->iteration, 'foot') !!}
                </th>
            @endforeach
        </tr>
    </tfoot>
@endif