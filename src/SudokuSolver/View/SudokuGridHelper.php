<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;

/**
 * Helps render a sudoku-grid
 */
class SudokuGridHelper
{
    /**
     * @var Template
     */
    private $rowTpl;
    private $gridTpl;

    public function __construct()
    {
        $this->rowTpl = Template::getTemplate('sudokuRow');
        $this->gridTpl = Template::getTemplate('sudokuContainer');
    }

    /**
     * Get HTML of row with specified contents
     * @param  string $rowHtml contents of row element
     * @return string          HTML
     */
    protected function renderRow($rowHtml)
    {
        return $this->rowTpl->render(array('content' => $rowHtml));
    }

    /**
     * Get HTML of entire grid with specified contents
     * @param  string $gridHtml contents of grid element
     * @return string           HTML
     */
    protected function renderGrid($gridHtml)
    {
        return $this->gridTpl->render(array('content' => $gridHtml));
    }

    /**
     * Render the sudoku
     * @param  callable $getCellHtml Receives ($row, $column) of the cell it is expected to return
     * @return string                HTML
     */
    public function render(callable $getCellHtml)
    {
        $sudokuHtml = '';
        for ($row = 0; $row < 9; $row++) {
            $rowHtml = '';
            for ($col = 0; $col < 9; $col++) {
                // Append cell to row
                $rowHtml .= $getCellHtml($row, $col);
            }
            // Append row to grid
            $sudokuHtml .= $this->renderRow($rowHtml);
        }
        return $this->renderGrid($sudokuHtml);
    }
}
