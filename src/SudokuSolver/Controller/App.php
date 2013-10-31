<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\Template;
use SudokuSolver\View\AppView;

class App
{

    /**
     * @var AppView
     */
    private $view;

    private $router;

    public function __construct()
    {
        $this->view = new AppView();
        $this->router = new Router();

        $html = $this->router->dispatch();
        print $this->view->render($html);
    }
}
