<?php

namespace SudokuSolver\View;

use SudokuSolver\Model\Solution;

/**
 * Displays an immutable solution where cells are marked as
 * part of the original puzzle or solved by the system.
 */
class SolutionView extends AbstractSudokuView
{
    /**
     * @var Solution
     */
    protected $solution;

    /**
     * @var Template
     */
    private $gridTpl;
    private $rowTpl;
    private $cellTpl;

    public function __construct(Solution $solution)
    {
        $this->solution = $solution;

        // Create templates
        $this->gridTpl = Template::getTemplate('sudoku-grid-static');
        $this->rowTpl = Template::getTemplate('sudoku-row');
        $this->cellTpl = Template::getTemplate('sudoku-cell-static');
    }

    /**
     * Returns static number-span, with class 'solved' if it has been solved
     * by the system. (From parent class)
     * @param  int $row
     * @param  int $col
     * @return string    HTML
     * @
     */
    protected function getCellHtml($row, $col)
    {
        $options = array(
            'content' => $this->solution->getCell($row, $col),
            'class' => $this->solution->isSolved($row, $col) ? 'solved' : ''
        );

        return $this->cellTpl->render($options);
    }

    /**
     * Render HTML through the row-template
     * @param  string $rowHtml
     * @return string          HTML
     */
    protected function getRowHtml($rowHtml)
    {
        return $this->rowTpl->render(array('content' => $rowHtml));
    }

    /**
     * Render HTML through the grid-template
     * @param  string $gridHtml
     * @return string           HTML
     */
    protected function getGridHtml($gridHtml)
    {
        return $this->gridTpl->render(array('content' => $gridHtml));
    }
}
