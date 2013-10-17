<?php

namespace SudokuSolver\View;

use SudokuSolver\View\AbstractSudokuView;
use SudokuSolver\View\Template;

/**
 * Displays a sudoku-grid with input elements for a user to manually
 * input a sudoku puzzle.
 */
class SudokuFormInputView extends AbstractSudokuView
{
    /**
     * @var Template
     */
    private $template;

    public function __construct()
    {
        parent::__construct();
        $this->template = Template::getTemplate('sudoku-cell-input');
    }

    public function getCellHtml($row, $col)
    {
        // TODO: JavaScript next on input
        // TODO: Persist already filled in numbers
        return $this->template->render(array('name' => "{$row}{$col}"));
    }
}
