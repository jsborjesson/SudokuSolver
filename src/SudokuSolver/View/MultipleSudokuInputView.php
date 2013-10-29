<?php

namespace SudokuSolver\View;

use SudokuSolver\View\SudokuInputView;
use SudokuSolver\Model\Sudoku;
use Exception;

/**
 * Extends the SudokuInputView functionality with the ability
 * to input multiple sudokus at once.
 */
abstract class MultipleSudokuInputView extends SudokuInputView
{

    /**
     * Get all input sudokus
     * @return Sudoku[]
     */
    abstract protected function getSudokus();

    /**
     * If multiple sudokus has been sent
     * @return bool
     */
    abstract public function hasMultipleSudokus();
}
