<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;

class AppView
{
    /**
     * @var Template
     */
    private $template;

    public function __construct()
    {
        $this->template = Template::get('boilerplate');
    }

    /**
     * Render the complete page
     * @param  string $body  HTML
     * @param  string $title
     * @return string        HTML
     */
    public function render($body, $title = 'Goodbye Sudoku')
    {
        return $this->template->render(
            array(
                'title' => $title,
                'content' => $body
            )
        );
    }
}
