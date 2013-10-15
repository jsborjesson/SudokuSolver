# This is the configuration for Compass

# Require dependencies for gumby
require 'modular-scale'
require 'sassy-math'

# Configure paths
http_path = "/"
css_dir = "public/css"
sass_dir = "public/scss"
images_dir = "public/img"
javascripts_dir = "public/js"

# Use the Composer-installed Gumby
add_import_path "./vendor/gumbyframework/gumby/sass/"


# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :expanded


# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass
