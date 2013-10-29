<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\MultipleSudokuInputView;
use SudokuSolver\View\SingleSudokuInputView;
use SudokuSolver\View\VisualSudokuInputView;
use SudokuSolver\View\TextAreaSudokuInputView;
use SudokuSolver\View\TextFileSudokuInputView;
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
        $inputView = new TextAreaSudokuInputView();
        return $this->handleInput($inputView);
    }

    public function fileAction()
    {
        $inputView = new TextFileSudokuInputView();
        return $this->handleInput($inputView);
    }

    private function handleInput(SudokuInputView $inputView)
    {
        if ($inputView->isSubmitted()) {
            if ($inputView instanceof MultipleSudokuInputView &&
                $inputView->hasMultipleSudokus()
            ) {
                // Multiple sudokus
                return $this->handleMultipleInput($inputView);
            } else {
                // Single sudoku
                return $this->handleSingleInput($inputView);
            }
        } else {
            // Show normal input
            return $inputView->render();
        }
    }

    private function handleSingleInput(SudokuInputView $inputView)
    {
        // TODO: validate

        // Get sudoku
        try {
            $sudoku = $inputView->getSudoku();
        } catch (Exception $e) {
            // show invalid sudoku error
            // TODO: return $inputView->showInvalidSudoku()?
            print 'invalid sudoku';
        }

        $solver = $this->getSolverInstance($inputView);
        $solution = Solution::getSolution($sudoku, $solver);

        // show solution
        $solutionView = new SolutionView($solution);
        return $solutionView->render();
        // else show error
    }

    private function handleMultipleInput(MultipleSudokuInputView $inputView)
    {
        // Get sudokus
        try {
            // Already tested for hasMultiple in handleInput
            $sudokus = $inputView->getSudokus();
        } catch (Exception $e) {
            // TODO: error handling
            print 'one or more sudokus invalid';
            return $inputView->render();
        }

        // FIXME: Code duplication
        // TODO: Error handling
        // Try to solve
        $solver = $this->getSolverInstance($inputView);

        // Solve all sudokus
        $solutionHtml = '';
        foreach ($sudokus as $sudoku) {
            // TODO: What happens when not solved?
            $solution = Solution::getSolution($sudoku, $solver);

            $solutionView = new SolutionView($solution);
            $solutionHtml .= $solutionView->render();
        }
        return $solutionHtml;
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
