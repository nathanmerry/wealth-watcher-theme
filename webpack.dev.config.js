'use strict';

/**
 * External.
 */
const webpack = require('webpack');
const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');


/**
 * Configure Webpack Dev Server.
 *
 * @return {Object}
 */
const configureDevServer = () => {
  return {
    contentBase: path.join(__dirname, 'scratch'),
    host: 'localhost',
    allowedHosts: ['bi.test'],
    hot: false,
    inline: true,
    overlay: true,
    open: false,
    port: 9000,
    headers: { "Access-Control-Allow-Origin": "*" },
    //before(app, server, compiler) {
      //const watchFiles = ['.html', '.twig'];
        //console.log(compiler.watchFileSystem);
      //compiler.hooks.done.tap('MyPlugin', (params) => {



        // const changedFiles = Object.keys(compiler.watchFileSystem.watcher.mtimes);
        // console.log(changedFiles);
  
        // if (
        //   this.hot &&
        //   changedFiles.some(filePath => watchFiles.includes(path.parse(filePath).ext))
        // ) {
        //   server.sockWrite(server.sockets, 'content-changed');
        // }



      //});
    //}
  };
};

/**
 * Export the config.
 *
 * @type {Object}
 */
module.exports = {
  devServer: configureDevServer(),
  devtool: 'source-map',
  entry: {
    bundle: './src/assets/bundle.js',
    twig: './src/views/twig.js'
  },
  mode: 'development',
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader', 'postcss-loader'],
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
      {
        test: /\.twig$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              context: 'src',
              name: '[path][name].[ext]',
            }
          },
          // { loader: 'extract-loader' },
          // {
          //   loader: 'html-loader',
          //   options: {
          //     minimize: false
          //   },
          // },
        ],
      },
    ]
  },
  output: {
    filename: '[name].js',
    path: path.join(__dirname, '/scratch'),
    publicPath: 'http://localhost:9000/',
    // clean: true
  },
  plugins: [
    new BrowserSyncPlugin({
      host: "localhost",
      port: 3000,
      proxy: "bi.test", // devserver
      files: [
        './src/views/**/*.twig'
      ]
    },{
      // prevent BrowserSync from reloading the page
      // and let Webpack Dev Server take care of this
      reload: false
    })
  ],
};