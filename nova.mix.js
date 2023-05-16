const mix = require('laravel-mix')
const path = require('path')

class NovaExtension {
  name() {
    return 'nova-searchable-filter'
  }

  register(name) {
    this.name = name
  }

  webpackConfig(webpackConfig) {
    webpackConfig.externals = {
      vue: 'Vue',
    }

    webpackConfig.resolve.alias = {
      ...(webpackConfig.resolve.alias || {}),
      'laravel-nova': path.join(
        __dirname,
        './vendor/laravel/nova/resources/js/mixins/index.js'
      ),
    }

    webpackConfig.output = {
      uniqueName: this.name,
    }
  }
}

mix.extend('nova', new NovaExtension())
