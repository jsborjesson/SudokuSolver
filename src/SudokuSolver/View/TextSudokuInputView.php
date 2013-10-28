<?php

namespace SudokuSolver\View;

use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\Template;
use SudokuSolver\Model\SudokuReader;

// TODO: MultipleSudokuInputView
class TextSudokuInputView extends SudokuInputView
{
    /**
     * @var Template
     */
    private $template;

    private static $inputTextName = 'sudokuText';
    private static $zeroCharName = 'zeroChar';
    private static $delimiterName = 'sudokuDelimiter';

    public function __construct()
    {
        parent::__construct();
        $this->template = Template::getTemplate('sudokuTextInput');
    }

    // ------ From SudokuInputView ------

    /**
     * @return string HTML
     */
    public function renderSudokuInput()
    {
        return $this->template->render(
            array(
                'sudokuName' => self::$inputTextName,
                'zeroCharName' => self::$zeroCharName,
                'sudokuDelimiterName' => self:: $delimiterName
            )
        );
    }


    /**
     * From SudokuInputView
     * @return Sudoku
     */
    public function getSudoku()
    {
        return SudokuReader::fromString($this->getText(), $this->getZeroChar());
    }

    // ------ Helpers ------

    /**
     * Returns input zeroChar or 0 if empty
     * @return string char
     */
    private function getZeroChar()
    {
        return isset($_POST[self::$zeroCharName]) ? $_POST[self::$zeroCharName] : 0;
    }

    private function getText()
    {
        return isset($_POST[self::$inputTextName]) ? $_POST[self::$inputTextName] : '';
    }

}
