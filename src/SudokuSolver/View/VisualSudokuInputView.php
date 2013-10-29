<?php

namespace SudokuSolver\View;

use SudokuSolver\Model\Sudoku;
use SudokuSolver\View\Template;
use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\SudokuGridHelper;
use Exception;

/**
 * Displays a sudoku-grid with input elements for a user to manually
 * input a sudoku puzzle.
 */
class VisualSudokuInputView extends SudokuInputView
{
    /**
     * @var Template
     */
    private $cellTpl;

    /**
     * @var SudokuGridHelper
     */
    private $gridHelper;

    /**
     * Minimum number of cells
     * @var integer
     */
    private $minimumCells;

    /**
     * @param integer $minimumCells The least amount of cells that needs to be filled
     */
    public function __construct($minimumCells = 17)
    {
        parent::__construct();
        $this->minimumCells = $minimumCells;
        $this->cellTpl = Template::getTemplate('sudokuCellInput'); // input field
        $this->gridHelper = new SudokuGridHelper();
    }

    /**
     * Input field for a cell
     * @param  integer $row
     * @param  integer $col
     * @return string   HTML
     */
    protected function getCellHtml($row, $col)
    {
        // FIXME: Very subtle string dependency in concatenating the name, class internal
        return $this->cellTpl->render(array('name' => $row . $col));
    }

    // ------ From SudokuInputView ------

    /**
     * @return string HTML
     */
    public function renderSudokuInput()
    {
        return $this->gridHelper->render(function ($row, $col) {
            return $this->cellTpl->render(
                array(
                    'name' => $row . $col,
                    'value' => $this->getCellInput($row, $col)
                )
            );
        });
    }

    /**
     * From SudokuInputView
     * @return Sudoku
     */
    public function getSudoku()
    {
        $arr = array();

        // Collect all inputs
        for ($row = 0; $row < 9; $row++) {
            $arr[$row] = array();
            for ($col = 0; $col < 9; $col++) {
                $arr[$row][$col] = $this->getCellInputDigit($row, $col);
            }
        }

        $sudoku = new Sudoku($arr);

        // Count
        if ($sudoku->countFilledCells() < $this->minimumCells) {
            throw new Exception('You must fill at least ' . $this->minimumCells . ' cells!');
        }

        return $sudoku;
    }

    // ------ Helpers ------

    /**
     * Get exact input of the input cell
     * @param  integer $row
     * @param  integer $col
     * @return string
     */
    private function getCellInput($row, $col)
    {
        // TODO: Validation
        if (isset($_POST[$row . $col])) {
            return $_POST[$row . $col];
        }
    }

    /**
     * Same as getCellInput, but always returns a valid digit.
     * If a valid digit is not entered, 0 is returned.
     * @param  integer $row
     * @param  integer $col
     * @return integer      0-9
     */
    private function getCellInputDigit($row, $col)
    {
        $input = $this->getCellInput($row, $col);
        return preg_match('/^[1-9]$/', $input) ? intval($input) : 0;
    }
}
