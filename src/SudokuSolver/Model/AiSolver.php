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
    public function solve(Sudoku $sudoku, $deep = true)
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
        if ($deep) {
            $this->gamblingScan($sudoku);
        }

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


    private function gamblingScan(Sudoku $sudoku)
    {
        // Try cells with the fewest possible options
        for ($maximumOptions = 2; $maximumOptions < 9; $maximumOptions++) {

            for ($row = 0; $row < 9; $row++) {
                for ($col = 0; $col < 9; $col++) {

                    // Move on if already solved
                    if ($sudoku->isFilled($row, $col)) {
                        continue;
                    }

                    $options = $sudoku->getOptionsForCell($row, $col);
                    if (count($options) <= $maximumOptions) {

                        foreach ($options as $option) {
                            $sudoku->setCell($row, $col, $option);

                            if ($this->solve($sudoku, false)) {
                                return true;
                            }
                        }
                    }

                }
            }
        }
    }


    /**
     * @param  Sudoku $sudoku
     * @return bool           If **made progress**
     */
    private function advancedScan(Sudoku $sudoku)
    {

            // Check all units
                // Check all options
                    // Check all indices
                        // Count if option is valid at current unit/index
                    // If one option is only valid at one index - insert it
        return;

        // Check rows
        if ($this->checkUnit(
            $sudoku,
            function ($unit, $index) use ($sudoku) {
                return $sudoku->getOptionsForCell($unit, $index);
            },
            function ($unit, $index, $value) use ($sudoku) {
                $sudoku->setCell($unit, $index, $value);
            }
        )) {
            return true;
        }

        // Check cols
        if ($this->checkUnit(
            $sudoku,
            function ($unit, $index) use ($sudoku) {
                return $sudoku->getOptionsForCell($index, $unit);
            },
            function ($unit, $index, $value) use ($sudoku) {
                $sudoku->setCell($index, $unit, $value);
            }
        )) {
            return true;
        }

        // Check groups
        // Check rows
        if ($this->checkUnit(
            $sudoku,
            function ($unit, $index) use ($sudoku) {
                $row = floor($index / 3);
                $col = floor($index % 3);

                return $sudoku->getOptionsForCell($unit, $index);
            },
            function ($unit, $index, $value) use ($sudoku) {
                $sudoku->setCell($unit, $index, $value);
            }
        )) {
            return true;
        }
    }

    private function checkUnit(Sudoku $sudoku, callable $getOptions, callable $setCellInUnit)
    {
        // For all units
        for ($unit = 0; $unit < 9; $unit++) {

            // All possible options
            for ($option = 0; $option < 9; $option++) {

                // Count the times that option is valid in this unit
                $times = 0;

                $lastIndex = -1;

                for ($index = 0; $index < 9; $index++) {

                    // If option is valid in this cell

                    // CALLBACK
                    $options = $getOptions($unit, $index);

                    if (in_array($option, $options)) {
                        $times++;
                        $lastIndex = $index;

                        // Break? on 2?
                    }
                }

                // If the option can only go in one place - insert it there
                if ($times == 1) {
                    // THIS
                    $setCellInUnit($unit, $index, $option);
                    return true;
                }
            }
        }
        return false;
    }
}
