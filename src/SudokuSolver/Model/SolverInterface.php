<?php

namespace SudokuSolver\Model;

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
