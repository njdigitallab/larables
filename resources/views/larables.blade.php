<div {!! $table->getWrapperAtts() !!}>
    @include(Larables::viewsId().'::top-bar')
    @include(Larables::viewsId().'::table')
    @include(Larables::viewsId().'::bottom-bar')
</div>