<tbody {!! $table->getTbodyAtts() !!}>
    @if ($table->hasData())
        @foreach ($table->getData() as $item)
            <tr {!! $table->getTbodyTrAtts($item, $loop->iteration) !!}>
                @foreach ($table->getColumns() as $columnId => $columnTitle)
                    <td {!! $table->getTbodyTdAtts($item, $columnId, $loop->iteration, $loop->parent->iteration) !!}>
                        {!! $table->getContentForColumn($item, $columnId, $loop->iteration, $loop->parent->iteration) !!}
                    </td>
                @endforeach
            </tr>
        @endforeach
    @else
        <tr {!! $table->getTbodyTrNoItemAtts() !!}>
            <td {!! $table->getTbodyTdNoItemAtts() !!} colspan="{{ $table->getColumnsCount() }}">
                {!! $table->getNoItemMessage() !!}
            </td>
        </tr>
    @endif
</tbody>