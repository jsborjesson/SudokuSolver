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

    public function __construct()
    {
        $this->view = new AppView();

        // FIXME: Allow more controllers
        $this->ctrl = new SolveHandler();

        // Run the controller
        $this->dispatch();
    }

    // FIXME: Testing code
    private function dispatch()
    {
        switch ($_SERVER['QUERY_STRING']) {
            case 'solve=visual':
                $this->doVisual();
                break;
            case 'solve=text':
                $this->doText();
                break;
            case 'solve=file':
                $this->doFile();
                break;
            default:
                header('Location: ?solve=visual');
                break;
        }
    }

    private function doVisual()
    {
        $html = $this->ctrl->visualAction();
        print $this->view->render($html);
    }

    private function doText()
    {
        $html = $this->ctrl->textAction();
        print $this->view->render($html);
    }

    private function doFile()
    {
        $html = $this->ctrl->fileAction();
        print $this->view->render($html);
    }
}
