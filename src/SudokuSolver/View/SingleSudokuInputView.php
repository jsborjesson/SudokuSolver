<?php

namespace SudokuSolver\View;

abstract class SingleSudokuInputView extends SudokuInputView
{
    /**
     * Get the input sudoku
     * @return Sudoku
     */
    abstract public function getSudoku();
}
