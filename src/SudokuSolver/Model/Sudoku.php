<?php

namespace SudokuSolver\Model;

use Exception;

/**
 * Holds a sudoku and manages possible answers in cells
 */
class Sudoku
{

    /**
     * Holds the sudoku
     * @var array 2-dimensional 9x9 array of integers
     */
    private $sudoku = array();

    /**
     * @param int[][] $grid 9x9 grid of digits
     */
    public function __construct($grid)
    {
        // TODO: Lots of validation and assertions
        // TODO: Must be 9x9, must consist of only digits, must not have duplicates in rows/cols/groups
        $this->sudoku = $grid;
    }

    // TODO: Move to AbstractSolver?
    /**
     * Get currently valid solutions for a cell
     * @param  int $row
     * @param  int $col
     * @return int[]
     */
    public function getOptionsForCell($row, $col)
    {
        // Return empty on already filled cell
        if ($this->isFilled($row, $col)) {
            return array();
        }

        // all options
        $options = range(1, 9);
        // remove options
        $options = array_diff($options, $this->getRow($row));
        $options = array_diff($options, $this->getColumn($col));
        $options = array_diff($options, $this->getContainingGroup($row, $col));

        return array_values($options);
    }

    /**
     * Set the value in a cell
     * @param int $row
     * @param int $col
     * @param int $val
     */
    public function setCell($row, $col, $val)
    {
        // TODO: Assert constraints
        $this->sudoku[$row][$col] = $val;
    }

    /**
     * Set value in cell to 0
     * @param  int $row
     * @param  int $col
     */
    public function emptyCell($row, $col)
    {
        $this->setCell($row, $col, 0);
    }

    /**
     * Get value of cell
     * @param  int $row
     * @param  int $col
     * @return int
     */
    public function getCell($row, $col)
    {
        return $this->sudoku[$row][$col];
    }

    /**
     * Array of values in column
     * @param  int $col
     * @return int[]
     */
    public function getColumn($col)
    {
        return array_column($this->sudoku, $col);
    }

    /**
     * Array of values in row
     * @param  int $row
     * @return int[]
     */
    public function getRow($row)
    {
        return $this->sudoku[$row];
    }

    /**
     * Flat array of values in 3x3 section
     * @param  int $row any row in group
     * @param  int $col any column in group
     * @return int[]
     */
    public function getContainingGroup($row, $col)
    {
        // Find out which group the coordinates belong to
        $band = floor($row / 3);
        $stack = floor($col / 3);

        return $this->getGroup($band, $stack);
    }

    /**
     * Returns a group by index, for easier iteration
     * The indexing is:
     *
     *     0 1 2
     *     3 4 5
     *     6 7 8
     *
     * @param  int $index
     * @return int[]
     */
    public function getGroupByIndex($index)
    {
        $row = floor($index / 3);
        $col = floor($index % 3);

        return $this->getGroup($row, $col);
    }

    /**
     * Get contents of group as flat array
     * @param  int $band
     * @param  int $stack
     * @return int[]
     */
    private function getGroup($band, $stack)
    {
        assert($band >= 0 && $band <=2 && $stack >= 0 && $stack <=2, 'Index out of bounds, must be 0-2');

        $firstRow = $band * 3;
        $firstCol = $stack * 3;

        $values = array();

        // Collect the values
        for ($rowIx = $firstRow; $rowIx < $firstRow + 3; $rowIx++) {
            for ($colIx = $firstCol; $colIx < $firstCol + 3; $colIx++) {
                $values[] = $this->sudoku[$rowIx][$colIx];
            }
        }

        return $values;
    }

    /**
     * If a number is in the cell
     * @param  int  $row
     * @param  int  $col
     * @return bool
     */
    public function isFilled($row, $col)
    {
        return (bool)$this->sudoku[$row][$col];
    }

    /**
     * Check the sudoku for errors.
     *
     * Does nothing if:
     *     The sudoku is perfectly square, 9 high, 9 across.
     *     All cells contain a digit or are empty.
     *     No duplicates are found in any unit.
     *
     * If any of these criteria are met, it throws an exception.
     *
     * IMPORTANT: An empty sudoku will be considered valid.
     *
     * @throws Exception If sudoku is not valid
     */
    public function validate()
    {
        // TODO: Throw custom Exception types

        // Must be square 9x9
        $dimensionEx = new Exception('Sudoku must be exactly 9x9 cells');
        if (count($this->sudoku) != 9) {
            throw $dimensionEx;
        }
        forEachRow(function ($row) {
            if (count($row) != 9) {
                throw $dimensionEx;
            }
        });

        // All squares must be digits
        $this->forEachCell(function ($val) {
            if (! $this->isDigit($val)) {
                throw new Exception('Invalid cell value');
            }
        });

        // No duplicates can be found in any unit
        $this->forEachUnit(function ($unit, $ix, $unitType) {
            if ($this->arrayHasDuplicates($unit)) {
                throw new Exception("Duplicate value in $unitType $ix");
            }
        });
    }

    /**
     * Maps a function over every cell in the sudoku
     * @param  callable $func callback that takes 3 arguments: value in cell, row, column
     */
    private function forEachCell(callable $func)
    {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                $func($this->sudoku[$row][$col], $row, $col);
            }
        }
    }

    /**
     * Maps a function over every row in the sudoku
     * @param  callable $func callback that takes 2 arguments: array of row digits, row index
     */
    private function forEachRow(callable $func)
    {
        for ($row = 0; $row < 9; $row++) {
            $func($this->getRow($row), $row);
        }
    }

    /**
     * Maps a function over every column in the sudoku
     * @param  callable $func callback that takes 2 arguments: array of column digits, column index
     */
    private function forEachColumn(callable $func)
    {
        for ($col = 0; $col < 9; $col++) {
            $func($this->getColumn($col), $col);
        }
    }

    /**
     * Maps a function over every group in the sudoku
     * @param  callable $func callback that takes 2 arguments: array of group digits, group index
     */
    private function forEachGroup(callable $func)
    {
        for ($group = 0; $group < 9; $group++) {
            $func($this->getGroupByIndex($group), $group);
        }
    }

    /**
     * Maps a function over every unit in the sudoku
     * @param  callable $func callback that takes 3 arguments:
     *                        array of unit digits, unit index, and a string (row|column|group)
     */
    private function forEachUnit(callable $func)
    {
        for ($unit = 0; $unit < 9; $unit++) {
            $func($this->getRow($unit), $unit, 'row');
            $func($this->getColumn($unit), $unit, 'column');
            $func($this->getGroup($unit), $unit, 'group');
        }
    }

    // ---------- Helper methods ---------- //

    /**
     * If input is an integer between 0 and 9
     * @param  mixed  $val anything
     * @return bool        true if $val is a digit, all other values will return false
     */
    private function isDigit($val)
    {
        return is_int($val) && $val >= 0 && $val <= 9;
    }

    /**
     * Checks if a unit has duplicate values (empty cells are not considered duplicates)
     * @param  array  $arr
     * @return bool         True if duplicate is found
     */
    private function unitHasDuplicates(array $arr)
    {
        $arr = array_diff($arr, array(0)); // remove all empty cells from array
        return count($arr) !== count(array_unique($arr));
    }

    /**
     * If all cells are filled
     * @return bool
     */
    public function isSolved()
    {
        try {
            $this->forEachCell(function ($val) {
                if ($val == 0) {
                    throw new Exception();
                }
            });
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Makes sure that a clone of a Sudoku-object does not reference
     * the same sudoku-array.
     */
    public function __clone()
    {
        $copy = array();

        // Copy all the array values
        foreach ($this->sudoku as $rowIx => $row) {
            $copy[$rowIx] = array();
            foreach ($row as $colIx => $cell) {
                $copy[$rowIx][$colIx] = $cell;
            }
        }
        $this->sudoku = $copy;
    }

    /**
     * Useful for debugging
     * @return string
     */
    public function __toString()
    {
        $str = "<pre style='font-family:monospace'>\n";
        foreach ($this->sudoku as $rowIx => $row) {
            // Horizontal dividers
            $str .= ($rowIx > 0 && $rowIx % 3 == 0) ? "- - -   - - -   - - -\n" : '';
            foreach ($row as $colIx => $cell) {
                // Vertical dividers
                $str .= ($colIx > 0 && $colIx % 3 == 0) ? '| ' : '';
                // Number or dot
                $str .= $cell > 0 ? $cell : '.';
                // Alignment space
                $str .= ' ';
            }
            $str .= "\n";
        }
        $str .= "</pre>\n";
        return $str;
    }
}
