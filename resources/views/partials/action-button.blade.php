<button {!! $table->getActionButtonAtts($action, $item) !!}>
    @include(Larables::viewsId().'::partials.action-content')
</button>