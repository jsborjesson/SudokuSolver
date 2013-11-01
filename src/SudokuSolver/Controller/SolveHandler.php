<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\MultipleSudokuInputView;
use SudokuSolver\View\VisualSudokuInputView;
use SudokuSolver\View\TextAreaSudokuInputView;
use SudokuSolver\View\TextFileSudokuInputView;
use SudokuSolver\View\SolutionView;
use SudokuSolver\Model\Solution;
use SudokuSolver\Model\AiSolver;
use SudokuSolver\Model\NorvigSolver;
use Exception;

class SolveHandler
{

    /**
     * @var SudokuInputView
     */
    private $inputView;

    /**
     * @return string HTML
     */
    public function visualAction()
    {
        // FIXME: Remove testing value 3
        $this->inputView = new VisualSudokuInputView(3);
        return $this->handleInput();
    }

    /**
     * @return string HTML
     */
    public function textAction()
    {
        $this->inputView = new TextAreaSudokuInputView();
        return $this->handleMultipleInput();
    }

    /**
     * @return string HTML
     */
    public function fileAction()
    {
        $this->inputView = new TextFileSudokuInputView();
        return $this->handleMultipleInput();
    }


    /**
     * Handle a single submitted sudoku
     * @param  SudokuInputView $inputView
     * @return string HTML
     */
    private function handleInput()
    {
        if ($this->inputView->isSubmitted()) {

            // Get sudoku or show error
            try {
                $sudoku = $this->inputView->getSudoku();
            } catch (Exception $e) {
                return $this->inputView->renderError($e);
            }

            // Solve the sudoku
            $solver = $this->getSolverInstance();
            $solution = Solution::getSolution($sudoku, $solver);

            // Show solution
            $solutionView = new SolutionView($solution);
            return $solutionView->render();
        } else {
            return $this->inputView->render();
        }
    }

    /**
     * Handle multiple submitted sudokus
     * @param  MultipleSudokuInputView$this->inputView
     * @return string                               HTML
     */
    private function handleMultipleInput()
    {
        if ($this->inputView->isSubmitted() &&
            $this->inputView->hasMultipleSudokus()) {

            // Get sudokus
            try {
                // Already tested for hasMultiple in handleInput
                $sudokus = $this->inputView->getSudokus();
            } catch (Exception $e) {
                return $this->inputView->renderError($e);
            }

            // FIXME: Code duplication
            // TODO: Error handling
            // Try to solve
            $solver = $this->getSolverInstance();

            // Solve all sudokus
            $solutionHtml = '';
            foreach ($sudokus as $sudoku) {
                // TODO: What happens when not solved?
                $solution = Solution::getSolution($sudoku, $solver);

                $solutionView = new SolutionView($solution);
                $solutionHtml .= $solutionView->render();
            }
            return $solutionHtml;

        } else {

            // If only one sudoku is sent, use the other method
            return $this->handleInput();
        }
    }

    /**
     * An instance of the chosen solving algorithm
     * @param  SudokuInputView $inputView
     * @return SolverInterface
     */
    private function getSolverInstance()
    {
        $solver = $this->inputView->getAlgorithm();

        if ($solver == SudokuInputView::SOLVER_AI) {
            return new AiSolver();
        } elseif ($solver == SudokuInputView::SOLVER_NORVIG) {
            return new NorvigSolver();
        }
        throw new Exception("Not a valid solving algorithm: $solver");
    }
}
