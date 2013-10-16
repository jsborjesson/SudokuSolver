<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;

/**
 * Renders a SudokuGrid using child-class' getCellHtml()
 */
abstract class AbstractSudokuView
{

    /**
     * @var Template
     */
    private $rowTpl;

    /**
     * @var Template
     */
    private $gridTpl;

    /**
     * MUST be called by subclasses with `parent::__construct()
     */
    protected function __construct()
    {
        $this->gridTpl = Template::getTemplate('sudoku-grid');
        $this->rowTpl = Template::getTemplate('sudoku-row');
    }

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

    /**
     * Get HTML snippet of specified cell in sudoku.
     * @param  int $row
     * @param  int $col
     * @return string   HTML
     */
    abstract protected function getCellHtml($row, $col);

    /**
     * Render HTML through the row-template
     * @param  string $rowHtml
     * @return string          HTML
     */
    private function getRowHtml($rowHtml)
    {
        return $this->rowTpl->render(array('content' => $rowHtml));
    }

    /**
     * Render HTML through the grid-template
     * @param  string $gridHtml
     * @return string           HTML
     */
    private function getGridHtml($gridHtml)
    {
        return $this->gridTpl->render(array('content' => $gridHtml));
    }
}
