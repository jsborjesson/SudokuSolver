<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;

/**
 * Renders a SudokuGrid using child-class' getCellHtml()
 */
abstract class AbstractSudokuView
{
    /**
     * Get HTML snippet of specified cell in sudoku.
     * @param  int $row
     * @param  int $col
     * @return string   HTML
     */
    abstract protected function getCellHtml($row, $col);

    /**
     * Uses the child-class' getCellHtml to render the entire sudoku
     * @return string HTML
     */
    public function render()
    {
        $sudokuHtml = '';
        for ($row = 0; $row < 9; $row++) {
            $rowHtml = '';
            for ($col = 0; $col < 9; $col++) {
                // Append cell to row
                $rowHtml .= $this->getCellHtml($row, $col);
            }
            // Append row to grid
            $sudokuHtml .= $this->getRowHtml($rowHtml);
        }
        return $this->getGridHtml($sudokuHtml);
    }
}
