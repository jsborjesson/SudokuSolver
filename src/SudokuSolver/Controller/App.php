<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\Template;
use SudokuSolver\View\AppView;
use SudokuSolver\Controller\SolveHandler;

class App
{

    /**
     * @var AppView
     */
    private $view;

    /**
     * Redirect here if no route is matched
     * @var string
     */
    private static $fourOhFour = '?solve=visual';

    public function __construct()
    {
        $this->view = new AppView();
    }

    /**
     * Run the app
     */
    public function run()
    {
        $html = $this->dispatch();
        $this->renderPage($html);
    }

    /**
     * Renders the page
     * @param  string $pageHtml
     */
    private function renderPage($pageHtml)
    {
        print $this->view->render($pageHtml);
    }

    /**
     * Redirect to 404-page
     */
    private function notFound()
    {
        header('Location: ' . self::$fourOhFour);
    }

    /**
     * Run the appropriate action based on URL
     * @return string HTML
     */
    private function dispatch()
    {
        // There is only one handler right now, might as well create it right away
        $ctrl = new SolveHandler();

        switch ($_SERVER['QUERY_STRING']) {
            case 'solve=visual':
                return $ctrl->visualAction();
                break;
            case 'solve=text':
                return $ctrl->textAction();
                break;
            case 'solve=file':
                return $ctrl->fileAction();
                break;
            default:
                $this->notFound();
                break;
        }
    }
}
