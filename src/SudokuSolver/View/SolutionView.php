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
    private $solution;

    /**
     * @var Template
     */
    private $template;

    public function __construct(Solution $solution)
    {
        parent::__construct();
        $this->solution = $solution;
        $this->template = Template::getTemplate('sudoku-cell-static');
    }

    /**
     * Returns static number-span, with class 'solved' if it has been solved
     * by the system. (From parent class)
     * @param  int $row
     * @param  int $col
     * @return string    HTML
     * @
     */
    public function getCellHtml($row, $col)
    {
        $options = array(
            'content' => $this->solution->getCell($row, $col),
            'class' => $this->solution->isSolved($row, $col) ? 'solved' : ''
        );

        return $this->template->render($options);
    }
}
