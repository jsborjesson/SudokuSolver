<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;
use SudokuSolver\Common\Router;

class SudokuInputTypeView
{

    /**
     * @var Template
     */
    private $template;

    // FIXME: String dependency
    // Links
    private static $visual = '?solve=visual';
    private static $text = '?solve=text';
    private static $file = '?solve=file';

    public function __construct()
    {
        $this->template = Template::getTemplate('inputTypeNavigation');
    }

    /**
     * @return string HTML
     */
    public function render()
    {
        // FIXME: Should not be in view
        $active = $_GET['solve'];

        return $this->template->render(
            array(
                'visualLink' => self::$visual,
                'textLink' => self::$text,
                'fileLink' => self::$file,
                $active . 'Class' => 'active'
            ),
            true // No other classes needed
        );
    }
}
