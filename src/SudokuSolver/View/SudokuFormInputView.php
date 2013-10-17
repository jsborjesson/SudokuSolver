<?php

namespace SudokuSolver\View;

use SudokuSolver\View\AbstractSudokuView;
use SudokuSolver\View\Template;

// TODO: SudokuInputInterface::getSudoku()
/**
 * Displays a sudoku-grid with input elements for a user to manually
 * input a sudoku puzzle.
 */
class SudokuFormInputView extends AbstractSudokuView
{
    /**
     * @var Template
     */
    private $cellTpl;

    public function __construct()
    {
        // Set templates
        $this->cellTpl = Template::getTemplate('sudoku-cell-input');
        $this->gridTpl = Template::getTemplate('sudoku-grid-input');
        $this->rowTpl = Template::getTemplate('sudoku-row');
    }

    /**
     * Input field for a cell
     * @param  int $row
     * @param  int $col
     * @return string   HTML
     */
    public function getCellHtml($row, $col)
    {
        // TODO: Persist already filled in numbers
        return $this->cellTpl->render(array('name' => "{$row}{$col}"));
    }

    /**
     * Get input cell contents
     * @param  int $row
     * @param  int $col
     * @return int      digit
     */
    private function getCellInput($row, $col)
    {

    }
}
