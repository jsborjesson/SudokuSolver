<?php

namespace SudokuSolver\View;

use SudokuSolver\View\TextSudokuInputView;
use SudokuSolver\View\Template;
use SudokuSolver\Model\SudokuReader;
use Exception;

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
        return $this->template->render(
            array(
                'sudokuName' => self::$inputTextName,
                'content' => $this->getText()
            )
        );
    }

    /**
     * Gets the text from the textarea
     * @return string empty if nothing has been sent
     */
    private function getText()
    {
        return isset($_POST[self::$inputTextName]) ? $_POST[self::$inputTextName] : '';
    }

    /**
     * Sudoku input text
     * @return string
     * @throws Exception If nothing has been sent
     */
    protected function getTextInput()
    {
        if ($this->getText()) {
            return $this->getText();
        }
        throw new Exception('You must input a sudoku');
    }
}
