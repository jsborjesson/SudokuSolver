<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;
use SudokuSolver\View\View;

/**
 * Renders a SudokuGrid using child-class' getCellHtml()
 */
abstract class AbstractSudokuView extends View
{
    /**
     * @var Template
     */
    private $rowTpl;
    private $gridTpl;

    /**
     * Get HTML snippet of specified cell in sudoku.
     * @param  int $row
     * @param  int $col
     * @return string   HTML
     */
    abstract protected function getCellHtml($row, $col);

    /**
     * NOTE: Important: MUST be called in child-classes: `parent::__construct`
     */
    protected function __construct()
    {
        $this->rowTpl = Template::getTemplate('sudokuRow');
        $this->gridTpl = Template::getTemplate('sudokuContainer');
    }

    // NOTE: These can be overridden in child if needed
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
            $sudokuHtml .= $this->renderRow($rowHtml);
        }
        return $this->renderGrid($sudokuHtml);
    }
}
