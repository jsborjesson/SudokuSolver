<?php
/**
 * This is meant to be an extremely simple templating engine.
 *
 * It is NOT meant to make templates the view-layer, as some frameworks do.
 * Its only purpuse is to break out HTML from the View-classes to their own files,
 * these templates are to be considered part of, or at the very least tightly coupled
 * to their associated view-classes.
 *
 * It works by taking an associative array, and replacing the keys in the template-file
 * with their corresponding value.
 *
 * Example:
 *
 *     // tpl.html
 *     <div class="test">{{content}}</div>
 *     // end tpl.html
 *
 *     $template = new Template('tpl.html');
 *     print $template->render(array('content' => 'testing'));
 *     // <div class="test">testing</div>
 */

namespace SudokuSolver\View;

use Exception;

class Template
{
    /**
     * @var string
     */
    private static $begin = '{{';

    /**
     * @var string
     */
    private static $end = '}}';

    /**
     * @var string
     */
    private $fileName;

    /**
     * Top level directory of the templates, with trailing slash
     * @var string
     */
    private static $templateDir = 'templates/';

    /**
     * File ending of template-files
     * @var string
     */
    private static $templateSuffix = '.html';

    /**
     * @param string $fileName Path to file containing the template
     */
    public function __construct($fileName)
    {
        if (! file_exists($fileName)) {
            throw new Exception("Template file not found: $fileName");
        }
        $this->fileName = $fileName;
    }

    /**
     * Automatically finds the template file by name and creates
     * a template from it.
     *
     * Example:
     *     # template-file is in /public/templates/template.html
     *     Template::getTemplate('template');
     *
     * @param  string $templateName name of template
     * @return Template
     */
    public static function getTemplate($templateName)
    {
        // TODO: Allow using fileSuffix manually
        return new Template(self::$templateDir . $templateName . self::$templateSuffix);
    }

    /**
     * Set the path where the templates are located
     * @param string $path
     */
    public static function setTemplateDirectory($path)
    {
        // TODO: Check if dir exists
        self::$templateDir = $path;
    }

    /**
     * Set the file ending of template files
     * @param string $fileEnding including dot, ex '.html'
     */
    public static function setTemplateSuffix($fileEnding)
    {
        self::$templateSuffix = $fileEnding;
    }

    // TODO: Allow optional placeholders that are removed on render
    /**
     * Render the template
     * @param  array  $options keys in template to replace with value in array
     * @return string          the rendered template
     */
    public function render(array $options = array())
    {
        $string = $this->getTemplateString();

        // Replace all the variables in template
        foreach ($options as $key => $value) {
            $search = $this->getSearchString($key);
            $string = str_replace($search, $value, $string);
        }

        return $string;
    }

    /**
     * Surrounds $key with template tags
     * @param  string $key
     * @return string
     */
    private function getSearchString($key)
    {
        return self::$begin . $key . self::$end;
    }

    /**
     * Get the template file as a string
     * @return string
     * @throws Exception If file not found
     */
    private function getTemplateString()
    {
        try {
            return file_get_contents($this->fileName);
        } catch (Exception $e) {
            throw new Exception('Template not found');
        }
    }
}
