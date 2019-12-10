const path = require("path");

const HtmlWebpackPlugin = require('html-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
  entry: path.join(__dirname, "./src", "index.js"),
  output: {
    //path: path.join(__dirname, "./src", "./../dist"),
    //filename: "index.js"
    path: path.join(__dirname, "./src", "./../public"),
    filename: "index.js"
  },
  module: {
    rules: [{
        test: /\.js$/,
        exclude: /node_modules/,
        use: ['babel-loader']
      }
    ]
  },
  devtool: 'inline-source-map',
  devServer: {
    contentBase: __dirname + "/src/",
    hot: true,
  },
  plugins: [
    
    new CleanWebpackPlugin(),
    new HtmlWebpackPlugin({
      title: 'Hot Module Replacement',
      template: './src/index.html'
    }),
  ],
};
