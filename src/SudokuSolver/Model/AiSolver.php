<?php

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;

/**
 * Solves a sudoku more like a human being, makes intelligent decisions instead
 * of brute forcing.
 */
class AiSolver implements SolverInterface
{

    /**
     * From SolverInterface
     * @param  Sudoku $sudoku
     * @return bool
     */
    public function solve(Sudoku $sudoku)
    {
        // NOTE: Pay attention to the different meanings of the scanning-functions return values!

        // Fast
        $solved = $this->fastScan($sudoku);
        if ($solved) {
            return true;
        }
        // DIED - move on to advanced logic

        // Slow
        $progress = $this->advancedScan($sudoku);
        if ($progress) {
            // Fall down to faster methods
            $this->solve($sudoku);
        }
        // DEAD - advancedScan does not check for final solution

        // If the method reaches this point, the logical steps have failed,
        // and it needs to make an educated guess
        // $this->nextGuess($sudoku);

    }

    /**
     * Solves as many cells as it can by entering values where there is only one possibility.
     * @param  Sudoku $sudoku
     * @return bool           If sudoku is **solved**
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
                return true;
            }

        } while ($makingProgress);

        // Nothing more to do here
        return false;

    }

    /**
     * @param  Sudoku $sudoku
     * @return bool           If **made progress**
     */
    private function advancedScan(Sudoku $sudoku)
    {

        // For all units
        for ($row = 0; $row < 9; $row++) {

            // All possible options
            for ($option = 0; $option < 9; $option++) {

                // Count the times that option is valid in this row
                $times = 0;

                $lastCol = -1;

                for ($col = 0; $col < 9; $col++) {

                    // If option is valid in this cell

                    $options = $sudoku->getOptionsForCell($row, $col);
                    if (in_array($option, $options)) {
                        $times++;
                        $lastCol = $col;

                        // Break? on 2?
                    }
                }

                // If the option can only go in one place - insert it there
                if ($times == 1) {
                    $sudoku->setCell($row, $lastCol, $option);
                    return true;
                }
            }
        }
        return false;
    }
}
