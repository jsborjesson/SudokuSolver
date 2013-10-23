<?php

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;

/**
 * Solves a sudoku more like a human being, makes intelligent decisions instead
 * of brute forcing.
 */
class AiSolver implements SolverInterface
{
    public function __construct()
    {
        //code...
    }

    public function solve(Sudoku $sudoku)
    {

        $progress = false;
        for ($index = 0; $index < 81; $index++) {
            if ($this->solveCell($sudoku, $index)) {
                $progress = true;
            }
        }

        // If it has made progress, start the loop over
        if ($progress) {
            $this->solve($sudoku);
        } else {
            // Else, run other methods
            // $this->solveByRules($sudoku);
        }
    }

    /**
     * Solves a cell if it only has one possible solution
     * @param  Sudoku $sudoku
     * @param  int $index
     * @return bool         True if solved, false if not
     */
    private function solveCell(Sudoku $sudoku, $index)
    {
        $row = floor($index / 9);
        $col = floor($index % 9);

        $options = $sudoku->getOptionsForCell($row, $col);

        if (count($options) == 1) {
            $sudoku->setCell($row, $col, $options[0]);
            return true;
        } else {
            return false;
        }
    }

    private function checkAndEnter($sudoku)
    {
        $makingProgress = false;
        $solved = false;

        do {

        } while ($makingProgress);
    }
}
