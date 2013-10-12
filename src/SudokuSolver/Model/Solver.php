<?php
/**
 * Solves sudoku puzzles.
 *
 * This class is based on the algorithm described by Peter Norvig at:
 * http://norvig.com/sudoku.html
 */

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;

class Solver
{
    /**
     * @var Sudoku
     */
    private $sudoku;

    /**
     * @param Sudoku $sudoku
     */
    public function __construct(Sudoku &$sudoku)
    {
        $this->sudoku = $sudoku;
    }

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
     *
     * @param  int $index index of cell
     * @return bool If the index resulted in a solution to the sudoku
     */
    private function findSolution($index)
    {
        // The end of the sudoku
        if ($index == 81) {
            return true;
        }

        $row = floor($index / 9);
        $col = floor($index % 9);

        // Move on to next square if already filled
        if ($this->sudoku->isFilled($row, $col)) {
            return $this->findSolution($index + 1);
        }

        // Get possible solutions for current cell
        $options = $this->sudoku->getOptionsForCell($row, $col);

        // Test every option
        foreach ($options as $option) {
            // Recurse down and see if the option yields a solution
            $this->sudoku->setCell($row, $col, $option);
            if ($this->findSolution($index + 1)) {
                return true;
            }
        }

        // Failed to find solution
        $this->sudoku->emptyCell($row, $col);
        return false;
    }

    /**
     * Solve the sudoku
     * @return bool If the sudoku was solved
     */
    public function solve()
    {
        return $this->findSolution(0);
    }
}
