// TODO: Only include this on form-input page
// TODO: 'Are you sure?' on clear-button
(function () {
    'use strict';

    var sudokuCellSelector = 'input.sudoku-cell';

    // Navigate sudoku and validate input
    // TODO: optimize
    $(sudokuCellSelector).keydown(function (event) {

        // The current input cell
        var $input = $(this);

        // 1 = right, -1 = left, 9 = below etc
        function navigate(amount) {

            // Get desired cell
            var index = $input.index(sudokuCellSelector);
            var nextElem = $(sudokuCellSelector).eq(index + amount);

            // Move to square
            if (nextElem != undefined) {
                $(nextElem).focus();
            }
        }

        // Set the value if it is valid
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

        // Do action
        switch (event.keyCode) {
            // Right
            case 48: // 0
            case 39: // right
            case 32: // space
                navigate(1);
                break;
            // Left
            case 8: // backspace
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

}());
