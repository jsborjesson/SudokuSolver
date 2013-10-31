<?php

namespace SudokuSolver\Controller;

class Router
{
    /**
     * Namespace of controllers to handle requests
     * @var string
     */
    private static $ctrlNamespace = 'SudokuSolver\\Controller\\';

    /**
     * What page to redirect to when no route is matched
     * @var string
     */
    private static $fourOhFour = '?solve=visual';

    /**
     * Calls an action in a controller based on the current URL
     * @return string HTML (actually, whatever the controller->action returns, but it should be HTML)
     */
    public function dispatch()
    {
        // Split the query
        $request = explode('=', $_SERVER['QUERY_STRING']);

        // Need both page and action
        if (count($request) < 2) {
            self::redirect(self::$fourOhFour);
        }

        // Get controller
        $ctrlName = ucfirst(self::$ctrlNamespace) . $request[0] . 'Handler';
        if (! class_exists($ctrlName)) {
            self::redirect(self::$fourOhFour);
        }

        // Get action
        $action = $request[1] . 'Action';
        if (! method_exists($ctrlName, $action)) {
            self::redirect(self::$fourOhFour);
        }

        // Call it!
        $ctrl = new $ctrlName();
        return $ctrl->$action();
    }

    /**
     * Get href to a page/action
     * @param  string $page
     * @param  string $action
     * @return string         href
     */
    public static function getLink($page, $action)
    {
        return '?' . $page . '=' . $action;
    }

    /**
     * Redirect to a page
     * @param  string $url redirect page
     */
    private static function redirect($url = '?')
    {
        header("Location: $url");
    }
}
