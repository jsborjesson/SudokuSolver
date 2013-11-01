<?php

namespace SudokuSolver\View;

use SudokuSolver\Model\Solution;
use SudokuSolver\View\SudokuGridHelper;
use SudokuSolver\View\SudokuInputTypeView;
use SudokuSolver\View\Template;

/**
 * Displays an immutable solution where cells are marked as
 * part of the original puzzle or solved by the system.
 */
class SolutionView
{
    /**
     * @var Solution
     */
    protected $solution;

    /**
     * @var Template
     */
    private $cellTpl;

    /**
     * @var SudokuGridHelper
     */
    private $gridHelper;

    public function __construct(Solution $solution)
    {
        $this->solution = $solution;

        $this->cellTpl = Template::getTemplate('sudokuCellStatic');
        $this->layoutTpl = Template::getTemplate('sudokuSolutionLayout');
        $this->gridHelper = new SudokuGridHelper();
    }

    public function render()
    {
        return $this->layoutTpl->render(
            array(
                'solution' => $this->renderSolution(),
                'timer' => $this->getExecutionTime(),
                'backUrl' => $_SERVER['REQUEST_URI'] // Redirect to same input type
            ),
            true
        );
    }

    /**
     * Printable execution time
     * @return string time with 2 decimals and unit
     */
    private function getExecutionTime()
    {
        $time = $this->solution->getExecutionTime();
        return round($time, 2) . 'ms';
    }

    private function renderSolution()
    {
        return $this->gridHelper->render(function ($row, $col) {

            $options = array(
                'content' => $this->solution->getCell($row, $col),
                'class' => $this->solution->isGiven($row, $col) ? 'solved' : ''
            );

            return $this->cellTpl->render($options);
        });
    }
}
