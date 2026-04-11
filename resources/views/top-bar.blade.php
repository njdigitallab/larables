@if ($table->shouldDisplayTopBar())
    <div {!! $table->getTopBarContainerAtts() !!}>
        @if ($table->shouldDisplayBulkOptions())
            @include(Larables::viewsId().'::partials.bulk-options')
        @endif

        @if ($table->shouldDisplayPerPageOptions())
            @include(Larables::viewsId().'::partials.per-page')
        @endif

        @if ($table->shouldDisplaySearch())
            @include(Larables::viewsId().'::partials.search')
        @endif

        @if ($table->shouldDisplayActiveSection())
            @include(Larables::viewsId().'::partials.active-section')
        @endif

        @if ($table->shouldDisplayTrashSection())
            @include(Larables::viewsId().'::partials.trash-section')
        @endif
    </div>
@endif