# A sample Guardfile
# More info at https://github.com/guard/guard#readme

guard 'livereload' do
  # Watch src-dir and index
  watch(%r{src/.+\.php})
  watch(%r{index.php})
  # Reload once the css-files get compiled, no need to watch the scss-dir
  watch(%r{public/.+\.(css|html)})
end
