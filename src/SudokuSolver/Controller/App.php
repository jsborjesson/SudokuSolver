<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\Template;
use SudokuSolver\View\AppView;
use SudokuSolver\Controller\SolveSudokuHandler;

class App
{

    /**
     * @var AppView
     */
    private $view;

    public function __construct()
    {
        Template::setTemplateDirectory('public/templates/'); // TODO: Make this a config-option instead

        $this->view = new AppView();

        // FIXME: Allow more controllers
        $this->ctrl = new SolveSudokuHandler();

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
                print 'file';
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
}
