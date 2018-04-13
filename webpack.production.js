const merge   = require('webpack-merge'),
      config  = require('./webpack.config'),
      Extract = require('mini-css-extract-plugin')

module.exports = merge(config, {
  mode: 'production',
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          Extract.loader,
          { loader: 'css-loader' }, 
          { loader: 'sass-loader' }
        ]
      }
    ]
  },
  plugins: [
    new Extract({
      filename: '[name].css'
    })
  ]
})