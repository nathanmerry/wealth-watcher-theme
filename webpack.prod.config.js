'use strict';

/**
 * External
 */
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const path = require('path');

const PUBLIC_PATH = '/wp-content/themes/bluespeaksfinance-theme/public/';

/**
 * Configure the CSS optimisation.
 *
 * @return {Object}
 */
const configureCssOptimisation = () => {
  return {
    cssProcessorOptions: {
      discardComments: true,
      map: {
        inline: false,
        annotation: true,
      },
      safe: true,
    },
  };
};

/**
 * Configure JavaScript optimisation.
 *
 * @return {Object}
 */
const configureJavaScriptOptimisation = () => {
  return {
    cache: true,
    parallel: true,
    sourceMap: true,
  };
};

/**
 * Configure Webpack Manifest.
 *
 * @return {Object}
 */
const configureManifest = () => {
  return {
    map: (file) => {
      // If the name has the path in already, or it's the webapp.html
      // file, which doesn't need it, we can just return and crack on.
      if (file.name.includes('/')) {
        return file;
      }

      // However, if the file name doesn't match those rules we need to
      // add it in to keep things nice and tidy. Note the special case -
      // if the extension is .map it's the js map file so correct that.
      let extension = file.name.split('.').pop();
      if ('map' === extension) {
        extension = 'js';
      }

      if (extension === 'js') {
        extension = 'scripts'
      } else if (extension === 'css') {
        extension = 'styles'
      }
      file.name = `${extension}/${file.name}`;
      return file;
    },
  };
};

/**
 * Export the config.
 *
 * @type {Object}
 */
module.exports = {
  devtool: 'source-map',
  entry: './src/assets/bundle.js',
  mode: 'production',
  optimization: {
    minimizer: [
      new OptimizeCSSAssetsPlugin(configureCssOptimisation())
    ],
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          { loader: MiniCssExtractPlugin.loader },
          {
            loader: 'css-loader',
            options: {
              import: true,
              importLoaders: 1
            }
          },
          { loader: 'postcss-loader' }
        ]
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/i,
        use: [
          "file-loader",
          {
            loader: "image-webpack-loader",
            options: {
              name: "./images/[path][name].[ext]",
              mozjpeg: {
                progressive: true,
                quality: 65
              },
              optipng: {
                enabled: true
              },
              pngquant: {
                quality: [0.65, 0.9],
                speed: 4
              },
              gifsicle: {
                interlaced: false
              },
              webp: {
                quality: 75
              }
            }
          }
        ]
      },
    ]
  },
  output: {
    filename: 'scripts/[name].[contenthash:8].js',
    path: path.join(__dirname, '/public'),
    publicPath: PUBLIC_PATH,
    clean: true
  },
  plugins: [
    new WebpackManifestPlugin(configureManifest()),
    new MiniCssExtractPlugin({ filename: 'styles/[name].[contenthash:8].css' })
  ],
};