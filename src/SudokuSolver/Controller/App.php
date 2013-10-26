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

        // TODO: AppView, violating MVC
        $this->view = new AppView();

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
                print 'text';
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
        $ctrl = new SolveSudokuHandler();
        $html = $ctrl->visualAction();
        print $this->view->render($html);
    }
}
