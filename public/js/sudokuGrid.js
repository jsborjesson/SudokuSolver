// TODO: Only include this on form-input page
// FIXME: BUG: Will not enter number when shift-tabbed back to filled square
// TODO: 'Are you sure?' on clear-button
(function () {
    'use strict';

    var sudokuCellSelector = 'input.sudoku-cell';

    // Move to next input square when a valid number/nothing is entered,
    // prevent other characters from being entered.
    $(sudokuCellSelector).keypress(function (event) {
        // Get char
        var c = String.fromCharCode(event.which);
        // If digit or space
        if (/[1-9\ ]/.test(c)) {

            // Get next input
            var index = $(this).index(sudokuCellSelector);
            var nextElem = $(sudokuCellSelector).eq(index + 1);

            // Move to next square
            if (nextElem != undefined) {
                $(nextElem).focus();
            }

        } else {
            // Don't allow inputting other chars
            return false;
        }
        // TODO: Previous on backspace
    });

}());
