<?php

namespace NjDigitalLab\Larables\Actions;

use NjDigitalLab\Larables\Larables;
use NjDigitalLab\Larables\Table;

class GetActionsColumnContent
{
    /**
     * Get the actions column content.
     */
    public static function execute(mixed $item, Table $table): string
    {
        $view = null;
        $itemActions = $table->getItemActions($item);

        foreach ($itemActions as $action => $data) {
            $route = static::getActionRoute($item, $data);
            $method = $data['method'] ?? 'get';

            $options = [
                'route' => $route,
                'method' => strtolower($method),
                'action' => $action,
                'table' => $table,
                'item' => $item,
            ];

            if ($table->getActionDisplayType() == 'button') {
                $view .= view(Larables::viewsId().'::partials.action-button', $options);
            } else {
                $view .= view(Larables::viewsId().'::partials.action-link', $options);
            }
        }

        $content = "<div ".$table->getActionContainerAtts($item).">";
        $content .= $view;
        $content .= "</div>";

        return $content;
    }

    /**
     * Get the action route.
     */
    protected static function getActionRoute(mixed $item, array $data): string
    {
        $route = $data['route'] ?? '';
        $routeName = $data['route_name'] ?? null;
        $args = $data['args'] ?? null;
        $passModel = $data['pass_model'] ?? true;

        if (! empty($route)) {
            return $route;
        }

        if (is_null($routeName)) {
            return '';
        }

        if (! is_null($args)) {
            return route($routeName, $args);
        }

        return $passModel ? route($routeName, $item) : route($routeName);
    }
}
