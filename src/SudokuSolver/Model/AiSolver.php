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
     * From SolverInterface.
     *
     * Uses all of the scanning algorithms to produce a solution
     *
     * @param  Sudoku $sudoku
     * @return bool
     */
    public function solve(Sudoku $sudoku)
    {
        // NOTE: Pay attention to the different meanings of the scanning-functions return values!

        if (! $this->shallowScan($sudoku)) {

            if (! $this->deepScan($sudoku)) {
                // Not solvable
                return false;
            }
        }

        return true;
    }

    /**
     * Uses both checkScan and bumpScan to try to get a solution using the
     * non-backtracking steps.
     * @param  Sudoku $sudoku
     * @return bool           If it was solved
     */
    public function shallowScan(Sudoku $sudoku)
    {
        $solved = false;

        // Loop as long as making progress
        while (! $solved) {

            // Checksolve
            $solved = $this->checkScan($sudoku);

            // Try to bump down to checking level
            if (! $solved) {

                $bump = $this->bumpScan($sudoku);

                // Bump failed
                if (! $bump) {
                    break;
                }
            }
        }

        return $solved;

    }

    /**
     * Checks if the sudoku is solved, while inserting obvious solutions
     * @param  Sudoku $sudoku
     * @return bool           If sudoku is **solved**
     */
    private function checkScan(Sudoku $sudoku)
    {

        do {
            // if the algorithm has achieved anything
            $makingProgress = false;

            // assume it's solved, set this to false as soon as empty cell is found
            $solved = true;

            // For each cell
            for ($row = 0; $row < 9; $row++) {
                for ($col = 0; $col < 9; $col++) {

                    // Move on if already solved
                    if ($sudoku->isFilled($row, $col)) {
                        continue;
                    } else {
                        $solved = false;
                    }

                    // Solve cell if only one option
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
     * Tries to bump the solution a step forward by using more advanced
     * techniques than the checkScan.
     * @param  Sudoku $sudoku
     * @return boolean         If the bump succeeded
     */
    private function bumpScan(Sudoku $sudoku)
    {
        // Collect possibilities
        $allOptions = array();
        for ($row = 0; $row < 9; $row++) {

            for ($option = 1; $option <= 9; $option++) {

                $times = 0;
                $rowIx = -1;
                $colIx = -1;

                for ($col = 0; $col < 9; $col++) {
                    $options = $sudoku->getOptionsForCell($row, $col);
                    if (in_array($option, $options)) {
                        $times++;
                        $rowIx = $row;
                        $colIx = $col;
                    }
                }
                if ($times == 1) {
                    $sudoku->setCell($rowIx, $colIx, $option);
                    return true;
                }
            }

        }
    }


    /**
     * Fallback shallow backtracking algorithm.
     *
     * This scan incorporates the shallowScan method.
     *
     * @param  Sudoku $sudoku
     * @return boolean         If the sudoku was solved
     */
    private function deepScan(Sudoku $sudoku)
    {
        $backup = clone($sudoku);

        // Try cells with the fewest possible options
        for ($maximumOptions = 2; $maximumOptions < 9; $maximumOptions++) {

            // Loop cells
            for ($row = 0; $row < 9; $row++) {
                for ($col = 0; $col < 9; $col++) {

                    // Move on if already solved
                    if ($sudoku->isFilled($row, $col)) {
                        continue;
                    }

                    // Loop options for this cell, if they are few enough
                    $options = $sudoku->getOptionsForCell($row, $col);
                    if (count($options) <= $maximumOptions) {

                        foreach ($options as $option) {
                            $sudoku->setCell($row, $col, $option);

                            if ($this->shallowScan($sudoku)) {
                                return true;
                            } else {
                                $sudoku = clone($backup);
                            }
                        }
                    }

                }
            }
        }

        return false;
    }

}
