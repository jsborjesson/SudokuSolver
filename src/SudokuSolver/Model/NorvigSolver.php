<?php
/**
 * Solves sudoku puzzles.
 *
 * This class is based on the algorithm described by Peter Norvig at:
 * http://norvig.com/sudoku.html
 */

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;

/**
 * Can either solve a sudoku directly:
 *
 *     $solver = new Solver();
 *     if ($solver->solve($sudoku)) {
 *         print '$sudoku is now solved!';
 *     } else {
 *         print 'could not solve sudoku';
 *     }
 *
 * Or you can use the getSolution-method that leaves the original intact,
 * but throws an error if it can't solve the sudoku.
 *
 *     $solution = Solver::getSolution($sudoku);
 *
 */
class NorvigSolver implements SolverInterface
{
    /**
     * Find the solution of a cell.
     *
     * This is the main solving algorithm.
     *
     * It takes the index of a cell to solve, instead of the row and column -
     * this makes it easier to iterate over.
     *
     * Example:
     *     second row, first cell = 9
     *     bottom right cell = 80
     *
     * @param  Sudoku $sudoku
     * @param  int $index index of cell
     * @return bool If the index resulted in a solution to the sudoku
     */
    private function findSolution(Sudoku $sudoku, $index)
    {
        // The end of the sudoku
        if ($index == 81) {
            return true;
        }

        $row = floor($index / 9);
        $col = floor($index % 9);

        // Move on to next square if already filled
        if ($sudoku->isFilled($row, $col)) {
            return $this->findSolution($sudoku, $index + 1);
        }

        // Get possible solutions for current cell
        $options = $sudoku->getOptionsForCell($row, $col);

        // Test every option
        foreach ($options as $option) {
            // Recurse down and see if the option yields a solution
            $sudoku->setCell($row, $col, $option);
            if ($this->findSolution($sudoku, $index + 1)) {
                return true;
            }
        }

        // Failed to find solution
        $sudoku->emptyCell($row, $col);
        return false;
    }

    /**
     * Solve the sudoku
     * @return bool If the sudoku was solved
     */
    public function solve(Sudoku $sudoku)
    {
        return $this->findSolution($sudoku, 0);
    }
}
