<?php

namespace SudokuSolver\Controller;

use SudokuSolver\View\Template;
use SudokuSolver\View\AppView;

// TODO: Should maybe be removed
use SudokuSolver\View\SolutionView;
use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\VisualSudokuInputView;
use SudokuSolver\Model\Solution;
use SudokuSolver\Model\NorvigSolver;

class App
{

    /**
     * @var AppView
     */
    private $view;

    public function __construct()
    {
        Template::setTemplateDirectory('public/templates/'); // TODO: Make this a config-option instead

        // TODO: AppView, violating MVC
        $this->view = new AppView();

        // Run the controller
        $this->dispatch();
    }

    // FIXME: Testing code
    private function dispatch()
    {
        switch ($_SERVER['QUERY_STRING']) {
            case 'solve/form':
                $this->doVisual();
                break;
            case 'solve/text':
                print 'text';
                break;
            case 'solve/file':
                print 'file';
                break;
            default:
                $this->doVisual();
                break;
        }
    }

    private function doVisual()
    {
        // TODO: Break out into controller
        // Test solver
        //$mainView = new SolutionView(Solution::getSolution($sudoku, new NorvigSolver()));

        // Main input view
        $inputView = new VisualSudokuInputView();

        if ($inputView->isSubmitted()) {
            // validate
            // try to solve
            try {
                $sudoku = $inputView->getSudoku();
            } catch (Exception $e) {
                // show invalid sudoku error
                // TODO: $inputView->showInvalidSudoku();
                print 'invalid sudoku';
            }

            // TODO: $inputView->getAlgorithm()
            $solver = new NorvigSolver();
            $solution = Solution::getSolution($sudoku, $solver);

            // show solution
            $solutionView = new SolutionView($solution);
            $html = $solutionView->render();
            print $this->view->render($html);
            // else show error
        } else {

            // Show input
            $mainHtml = $inputView->render();
            print $this->view->render($mainHtml);
        }
    }
}
