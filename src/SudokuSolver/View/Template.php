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
     *     // template-file is in /public/templates/template.html
     *     Template::getTemplate('template');
     *
     * IMPORTANT: This requires the constants TEMPLATE_DIR and TEMPLATE_SUFFIX to be defined
     *
     * @param  string $templateName name of template
     * @return Template
     */
    public static function getTemplate($templateName)
    {
        return new Template(TEMPLATE_DIR . $templateName . TEMPLATE_SUFFIX);
    }

    // TODO: Throw when key is not found in template file
    /**
     * Render the template
     * @param  array  $options keys in template to replace with value in array
     * @param  bool   $clean  optional, if set to true, removes all superflous placeholders
     * @return string         the rendered template
     * @throws Exception If $clean is false and not all placeholders have been accounted for
     */
    public function render(array $options = array(), $clean = false)
    {
        $string = $this->getTemplateString();

        // Replace all the variables in template
        foreach ($options as $key => $value) {
            $search = self::$begin . $key . self::$end;
            $string = str_replace($search, $value, $string);
        }

        // Clean or throw
        $pattern = '/' . self::$begin . '\w+' . self::$end . '/'; // any placeholder
        if ($clean) {
            // Remove all placeholders
            $string = preg_replace($pattern, '', $string);
        } else {
            // Throw if placeholders are left
            if (preg_match($pattern, $string) == 1) {
                throw new Exception("Remaining placeholders in template: $this->fileName");
            }
        }

        return $string;
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
            throw new Exception("Template not found: $this->fileName");
        }
    }
}
