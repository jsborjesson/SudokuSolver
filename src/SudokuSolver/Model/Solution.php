<?php

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;
use SudokuSolver\Model\Solver;

/**
 * Contains a solution to a sudoku
 */
class Solution
{
    /**
     * @var Sudoku
     */
    private $puzzle;

    /**
     * @var Sudoku
     */
    private $solution;

    /**
     * @param Sudoku $puzzle   Unsolved sudoku
     * @param Sudoku $solution Solved sudoku
     */
    public function __construct(Sudoku $puzzle, Sudoku $solution)
    {
        $this->puzzle = $puzzle;
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
     * If a cell in the sudoku was solved by the algorithm, or if it was
     * part of the original puzzle.
     * @param  int  $row
     * @param  int  $col
     * @return bool      True if solved by system, false if there to begin with
     */
    public function isSolved($row, $col)
    {
        return ! $this->puzzle->isFilled($row, $col);
    }

    /**
     * @return Sudoku
     */
    public function getOriginalSudoku()
    {
        // NOTE: Maybe return clone?
        return $this->puzzle;
    }

    /**
     * @return Sudoku
     */
    public function getSolvedSudoku()
    {
        return $this->solution;
    }
}
