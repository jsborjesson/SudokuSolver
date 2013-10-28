<?php

namespace SudokuSolver\View;

use SudokuSolver\View\SudokuInputView;
use SudokuSolver\Model\Sudoku;

abstract class MultipleSudokuInputView extends SudokuInputView
{
    /**
     * Get all inputted sudokus
     * @return Sudoku[]
     */
    abstract public function getSudokus();

    public function getSudoku()
    {
        // TODO: Implement SingleSudokuInputView and move getSudoku there?
        throw new \Exception('Only available in SingleSudokuInput');
    }
}
