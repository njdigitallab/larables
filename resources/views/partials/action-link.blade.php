<a {!! $table->getActionLinkAtts($action, $route, $item) !!}>
    @include(Larables::viewsId().'::partials.action-content')
</a>