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

        $solved = $this->fastScan($sudoku);

        if (! $solved) {

            $deep = $this->deepScan();
            if (! $deep) {
                // Not solvable
                return false;
            }
        }

        return $solved;
    }

    public function fastScan(Sudoku $sudoku)
    {
        $solved = false;

        while (! $solved) {
            // Checksolve
            $solved = $this->checkScan($sudoku);

            if (! $solved) {

                // Try to bump down
                $bump = $this->bumpScan($sudoku);

                if (! $bump) {
                    // Bump failed
                    return false;
                }
            }
        }

        return $solved;

    }

    /**
     * Solves as many cells as it can by entering values where there is only one possibility.
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

    private function bumpScan(Sudoku $sudoku)
    {
        // Foreach unit
        // Collect possibilities
        // If unique
        // insert

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


    private function insaneScan(Sudoku $sudoku)
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

                            if ($this->solve($sudoku, false)) {
                                return true;
                            } else {
                                $sudoku = clone($backup);
                            }
                        }
                    }

                }
            }
        }
    }

}
