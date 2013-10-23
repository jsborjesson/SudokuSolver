<?php

namespace SudokuSolver\Model;

/**
 * An algorithm that solves sudoku puzzles.
 *
 *     $solver = new ExampleSolver();
 *     if ($solver->solve($sudoku)) {
 *         print '$sudoku is now solved!';
 *     } else {
 *         print 'could not solve sudoku';
 *     }
 *
 */
interface SolverInterface
{
    /**
     * Solves a sudoku. The sudoku will be sent by
     * reference and WILL be changed directly.
     * @param  Sudoku $sudoku to solve
     * @return bool If the sudoku was solved successfully
     */
    public function solve(Sudoku $sudoku);
}
