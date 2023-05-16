let mix = require('laravel-mix')
let path = require('path')

require('./nova.mix')

mix
  .setPublicPath('dist')
  .js('resources/js/filter.js', 'js')
  .sass('resources/sass/filter.scss', 'css')
  .alias({ '@': path.join(__dirname, './vendor/laravel/nova/resources/js/') })
  .vue({ version: 3 })
  .nova('sereny/nova-searchable-filter')


