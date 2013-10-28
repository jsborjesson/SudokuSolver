<?php

namespace SudokuSolver\View;

use SudokuSolver\View\MultipleSudokuInputView;
use SudokuSolver\View\Template;
use SudokuSolver\Model\SudokuReader;

// TODO: MultipleSudokuInputView
class TextSudokuInputView extends MultipleSudokuInputView
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
     * Get all input sudokus
     * @return Sudoku[]
     */
    public function getSudokus()
    {
        // Split the string by delimiter
        $sudokuStrings = preg_split($this->getDelimiter(), $this->getText());

        // Parse all individual strings
        $sudokus = array();
        foreach ($sudokuStrings as $sudokuStr) {
            $sudokus[] = $this->parseSudoku($sudokuStr);
        }

        return $sudokus;
    }

    // ------ Helpers ------


    /**
     * Parse a sudoku from a string
     * @param  string $str sudoku
     * @return Sudoku
     */
    private function parseSudoku($str)
    {
        return SudokuReader::fromString($str, $this->getZeroChar());
    }

    /**
     * Sudoku input text
     * @return string
     */
    private function getText()
    {
        return isset($_POST[self::$inputTextName]) ? $_POST[self::$inputTextName] : '';
    }

    /**
     * Returns input zeroChar or 0 if empty
     * @return string char
     */
    private function getZeroChar()
    {
        return isset($_POST[self::$zeroCharName]) ? $_POST[self::$zeroCharName] : 0;
    }

    /**
     * @return string delimiter, newline if empty
     */
    private function getDelimiter()
    {
        return isset($_POST[self::$delimiterName]) ? $_POST[self::$delimiterName] : '\n';
    }
}
