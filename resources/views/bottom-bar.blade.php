@if ($table->shouldDisplayBottomBar())
    <div {!! $table->getBottomBarContainerAtts() !!}>
        {!! $table->displayPagination() !!}   
    </div>
@endif