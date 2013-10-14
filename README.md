# SudokuSolver

Should eventually solve sudoku puzzles.

## Standards

- HTML5
- [PHP-FIG](www.php-fig.org)

## Goals

- Make a complete project from design to deployment
- Learn more about design patterns and OOP
- Learn to use git more effectively, dev branch etc
- Maintain a well documented and high quality code-base
- To learn about and use automated testing

## Installing

TODO: Links to instructions

The tools needed to get this running are Composer and Ruby. They have their own
installation instructions. If you install Composer locally, you will need to replace
every instance of `composer` with `php composer.phar`.

### Composer

To install the projects dependancies:

    composer install


### Styles

I use Gumby framework for styles. It has a couple of dependencies. To generate
the CSS-files required for the live site:

    # Make sure the dependancies are installed
    gem install compass modular-scale sass

    # Compile the css
    compass compile


## Testing

    # Make sure Codeception is installed
    composer install --dev

Note: if you do not have `codecept` in your path, it is located in the vendor/bin directory.

    # Generate testing files
    codecept build

    # Run the unit tests
    codecept run unit
