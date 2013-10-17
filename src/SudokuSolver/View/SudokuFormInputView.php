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

    // ------- From AbstractSudokuView --------

    /**
     * Input field for a cell
     * @param  int $row
     * @param  int $col
     * @return string   HTML
     */
    protected function getCellHtml($row, $col)
    {
        // TODO: Persist already filled in numbers
        return $this->cellTpl->render(array('name' => "{$row}{$col}"));
    }

    protected function renderRow($rowHtml)
    {
        return $this->rowTpl->render(array('content' => $rowHtml));
    }

    protected function renderGrid($gridHtml)
    {
        return $this->gridTpl->render(array('content' => $gridHtml));
    }

    // ------- End AbstractSudokuView --------

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
