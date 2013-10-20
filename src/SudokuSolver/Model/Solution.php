<?php

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;
use SudokuSolver\Model\SolverInterface;
use Exception;

/**
 * Contains a solution to a sudoku
 */
class Solution
{
    /**
     * The unsolved puzzle
     * @var Sudoku
     */
    private $original;

    /**
     * The puzzle with the answers
     * @var Sudoku
     */
    private $solution;

    /**
     * @param Sudoku $original  Unsolved sudoku
     * @param Sudoku $solution  Solved sudoku
     */
    public function __construct(Sudoku $original, Sudoku $solution)
    {
        $this->original = $original;
        $this->solution = $solution;
    }

    /**
     * Get a cell in the solved sudoku
     * @param  int $row
     * @param  int $col
     * @return int
     */
    public function getCell($row, $col)
    {
        return $this->solution->getCell($row, $col);
    }

    /**
     * Facade.
     *
     * If a cell in the sudoku was solved by the algorithm, or if it was
     * part of the original puzzle.
     *
     * @param  int  $row
     * @param  int  $col
     * @return bool      True if solved by system, false if there to begin with
     */
    public function isFilledInOriginal($row, $col)
    {
        return ! $this->original->isFilled($row, $col);
    }

    /**
     * @return Sudoku
     */
    public function getOriginalSudoku()
    {
        // NOTE: Maybe return clone?
        return $this->original;
    }

    /**
     * @return Sudoku
     */
    public function getSolvedSudoku()
    {
        return $this->solution;
    }

    /**
     * Convenience method to create a solution-object, does not alter original sudoku.
     * @param  Sudoku $sudoku
     * @return Solution
     */
    public static function getSolution(Sudoku $sudoku, SolverInterface $algorithm)
    {
        $puzzle = $sudoku;
        $original = clone($sudoku);
        if ($algorithm->solve($puzzle)) {
            return new Solution($original, $puzzle);
        } else {
            throw new Exception('Could not solve sudoku');
        }
    }
}
