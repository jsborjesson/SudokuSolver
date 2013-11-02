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
     * If the program finished in time - this is used to show the execution
     * time error.
     * @var boolean
     */
    private $successfullCompletion = false;

    /**
     * Redirect here if no route is matched
     * @var string
     */
    private static $fourOhFour = '?solve=visual';

    public function __construct()
    {
        $this->view = new AppView();
        register_shutdown_function(array($this, 'shutdown'));
    }

    /**
     * Black magic to "catch" the execution time error
     */
    public function shutdown()
    {
        if (! $this->successfullCompletion) {
            // TODO: Show nice error-message
            print 'Could not solve the sudoku in time.';
        }
    }

    /**
     * Run the app
     */
    public function run()
    {
        $html = $this->dispatch();
        $this->renderPage($html);
        $this->successfullCompletion = true;
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
