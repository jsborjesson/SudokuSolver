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
        // TODO: Lots of validation
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
        $options = array_diff($options, $this->getGroup($row, $col));

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
    public function getGroup($row, $col)
    {
        // Find out which group the coordinates belong to
        $groupRow = floor($row/ 3) * 3;
        $groupCol = floor($col / 3) * 3;

        $values = array();

        // Collect the values
        for ($rowIx = $groupRow; $rowIx < $groupRow + 3; $rowIx++) {
            for ($colIx = $groupCol; $colIx < $groupCol + 3; $colIx++) {
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
     * If the sudoku is a valid sudoku.
     *
     * Returns true if all cells contain a digit or are empty, and no
     * duplicates are found in any row, column or group.
     *
     * IMPORTANT: An empty sudoku will be considered valid.
     *
     * @return bool
     */
    public function isValid()
    {
        // TODO: Implement is-valid
        throw new Exception("Not implemented");

        // All squares are digits
        // All rows/columns/groups do not have duplicates

    }

    /**
     * Check all cells in the sudoku with a function.
     *
     * The function receieves one parameter: the cell value, and should return
     * a boolean value.
     * @param  callable $func
     * @return bool           True if $func returned true on all cells, otherwise false.
     */
    private function checkAllCells(callable $func)
    {
        try {
            array_walk_recursive($this->sudoku, function ($value) {
                if (! $func($value)) {
                    throw new Exception();
                }
            });
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

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
     * @return bool
     */
    public function isSolved()
    {
        // TODO: Return all filled && valid
        // FIXME: This can fail, but probably won't.
        // The sum of a solved row/column/group (the sum of 1 through 9)
        $total = 45;

        // Check rows and columns
        for ($index = 0; $index < 9; $index++) {

            if (array_sum($this->getRow($index)) != $total) {
                return false;
            }

            if (array_sum($this->getColumn($index)) != $total) {
                return false;
            }
        }

        // Check groups
        for ($row = 1; $row < 9; $row += 3) {
            for ($col = 1; $col < 9; $col += 3) {
                if (array_sum($this->getGroup($row, $col)) != $total) {
                    return false;
                }
            }
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
