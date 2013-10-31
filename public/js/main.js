(function () {
    'use strict';

    // Initialize
    sudokuGrid();
    buttons();

    /**
     * Keyboard navigation and input validation for the visual sudoku input
     */
    function sudokuGrid() {

        var sudokuCellSelector = 'input.sudoku-cell';

        // When pressing a button in a cell
        $(sudokuCellSelector).keydown(function (event) {

            // The current input cell
            var $input = $(this);

            /**
             * Navigates the grid by an amount:
             * 1 = right, -1 = left, 9 = below etc
             *
             * @param  int amount
             */
            function navigate(amount) {

                // Get desired cell
                var index = $input.index(sudokuCellSelector);
                var nextElem = $(sudokuCellSelector).eq(index + amount);

                // Move to square
                if (nextElem != undefined) {
                    $(nextElem).focus();
                }
            }

            /**
             * Validates the input of a cell
             */
            function inputIfValid() {
                // Get char
                var c = String.fromCharCode(event.which);

                // If digit or space
                if (/[1-9\ ]/.test(c)) {

                    // input and move to next cell
                    $input.val(c);
                    navigate(1);

                }
            }

            // Do action - navigate or try to input number
            switch (event.keyCode) {
                // Right
                case 48: // 0
                case 32: // space
                    $input.val(''); // clear
                    // fall through
                case 39: // right
                    navigate(1);
                    break;
                // Left
                case 8: // backspace
                    $input.val(''); // clear
                    // fall through
                case 37: // left
                    navigate(-1)
                    break;
                // Down
                case 13: // enter
                case 40: // down
                    navigate(9);
                    break;
                // Up
                case 38:
                    navigate(-9);
                    break;
                // tabbing
                case 9:
                    event.shiftKey ? navigate(-1) : navigate(1);
                default:
                    inputIfValid();

            }
            return false;

        });
    }

    /**
     * Confirm-dialog when clicking clear, back button
     */
    function buttons() {
        // Confirm on clear
        $('#clear').click(function () {
            return confirm('Are you sure you want to clear everything?');
        });
        // Back button
        $('#back').click(function () {
            window.history.go(-1);
            return false;
        });
    }


}());
