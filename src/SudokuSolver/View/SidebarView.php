<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;

class SidebarView
{
    /**
     * @var Template
     */
    private $template;

    public function __construct()
    {
        $this->template = Template::getTemplate('sidebar');
    }

    public function render()
    {
        return $this->template->render();
    }
}
