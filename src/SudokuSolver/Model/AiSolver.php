<?php

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;

/**
 * Solves a sudoku more like a human being, makes intelligent decisions instead
 * of brute forcing.
 */
class AiSolver implements SolverInterface
{
    const DEAD = 0;
    const PROGRESS = 1;
    const SOLVED = 2;

    public function __construct()
    {
        //code...
    }

    public function solve(Sudoku $sudoku)
    {
        $status = self::DEAD;

        // Fast
        $status = $this->fastScan($sudoku);
        if ($status === self::SOLVED) {
            return true;
        }
        // DEAD or PROGRESS both need to move on to advanced scan

        // Slow
        $status = $this->advancedScan($sudoku);
        if ($status === self::PROGRESS) {
            // Fall down to faster methods
            $this->solve($sudoku);
        }
        // DEAD - advancedScan does not check for final solution

        // If the method reaches this point, the logical steps have failed,
        // and it needs to make an educated guess
        $this->nextGuess($sudoku);

    }

    /**
     * Solves a cell if it only has one possible solution
     * @param  Sudoku $sudoku
     * @param  int $index
     * @return int          DEAD | PROGRESS | SOLVED
     */
    private function fastScan(Sudoku $sudoku)
    {

        do {
            // if the algorithm has achieved anything
            $makingProgress = false;

            // assume it's solved, set this to false as soon as empty cell is found
            $solved = true;

            // TODO: $sudoku->forEachSquare(func($row, $col, $val))
            // For each cell
            for ($row = 0; $row < 9; $row++) {
                for ($col = 0; $col < 9; $col++) {

                    // Move on if already solved
                    if ($sudoku->isFilled($row, $col)) {
                        continue;
                    } else {
                        $solved = false;
                    }

                    $options = $sudoku->getOptionsForCell($row, $col);
                    if (count($options) == 1) {
                        $sudoku->setCell($row, $col, $options[0]);
                        $makingProgress = true;
                    }

                }
            }

            // No cells left unsolved
            if ($solved) {
                return self::SOLVED;
            } elseif ($makingProgress) {

            }

        } while ($makingProgress);

    }

    private function checkAndEnter($sudoku)
    {
        $makingProgress = false;
        $solved = false;

        do {

        } while ($makingProgress);
    }
}
