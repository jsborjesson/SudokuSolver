<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\VisualSudokuInputView;
use SudokuSolver\View\TextSudokuInputView;
use SudokuSolver\View\SolutionView;
use SudokuSolver\Model\Solution;
use SudokuSolver\Model\AiSolver;
use SudokuSolver\Model\NorvigSolver;
use Exception;

class SolveSudokuHandler
{
    /**
     * @return string HTML
     */
    public function visualAction()
    {
        $inputView = new VisualSudokuInputView();
        return $this->handleInput($inputView);
    }

    public function textAction()
    {
        $inputView = new TextSudokuInputView();
        return $this->handleInput($inputView);
    }

    private function handleInput(SudokuInputView $inputView)
    {
        if ($inputView->isSubmitted()) {
            // TODO: validate

            // try to solve
            try {
                $sudoku = $inputView->getSudoku();
            } catch (Exception $e) {
                // show invalid sudoku error
                // TODO: $inputView->showInvalidSudoku()?
                print 'invalid sudoku';
            }

            $solver = $this->getSolverInstance($inputView);
            $solution = Solution::getSolution($sudoku, $solver);

            // show solution
            $solutionView = new SolutionView($solution);
            return $solutionView->render();
            // else show error
        } else {
            // Show input
            return $inputView->render();
        }
    }

    /**
     * An instance of the chosen solving algorithm
     * @return SolverInterface
     */
    private function getSolverInstance(SudokuInputView $inputView)
    {
        $solver = $inputView->getAlgorithm();

        if ($solver == SudokuInputView::SOLVER_AI) {
            return new AiSolver();
        } elseif ($solver == SudokuInputView::SOLVER_NORVIG) {
            return new NorvigSolver();
        }
        throw new Exception("Not a valid solving algorithm: $solver");
    }

}
