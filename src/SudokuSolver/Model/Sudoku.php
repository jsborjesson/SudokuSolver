<?php

namespace SudokuSolver\Model;

/**
 * Holds a sudoku and accessor methods
 */
class Sudoku extends SudokuGrid
{

    /**
     * Checks so all numbers in grid are valid digits
     * @return boolean
     */
    public function isValid()
    {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if (! self::isDigit($this->getSquare($row, $col))) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Returns true for integer values of 0-9, false for everything else
     * @param  int  $number
     * @return boolean
     */
    public static function isDigit($number)
    {
        return is_int($number) && $number >= 0 && $number <= 9;
    }

    /**
     * Useful for console debugging
     * @return string visualization of grid
     */
    public function __toString()
    {
        $str = " -------------------\n";
        for ($row = 0; $row < 9; $row++) {
            $str .= '| ';
            for ($col = 0; $col < 9; $col++) {
                $str .= $this->sudoku[$row][$col] . ' ';
            }
            $str .= "|\n";
        }
        $str .= " -------------------\n";
        return $str;
    }
}
