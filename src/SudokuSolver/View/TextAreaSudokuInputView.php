<?php

namespace SudokuSolver\View;

use SudokuSolver\View\TextSudokuInputView;
use SudokuSolver\View\Template;
use SudokuSolver\Model\SudokuReader;

class TextAreaSudokuInputView extends TextSudokuInputView
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var string
     */
    private static $inputTextName = 'sudokuText';

    public function __construct()
    {
        parent::__construct();
        $this->template = Template::getTemplate('sudokuTextAreaInput');
    }

    // ------ From TextSudokuInputView ------

    /**
     * @return string HTML
     */
    protected function renderTextInput()
    {
        return $this->template->render(array('sudokuName' => self::$inputTextName));
    }

    /**
     * Sudoku input text
     * @return string
     */
    protected function getTextInput()
    {
        return isset($_POST[self::$inputTextName]) ? $_POST[self::$inputTextName] : '';
    }
}
