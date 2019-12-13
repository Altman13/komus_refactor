const path = require("path");

const HtmlWebpackPlugin = require("html-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");

module.exports = {
  entry: [
    path.join(__dirname, "./src", "index.js"),
    path.join(__dirname, "./src", "App.css")
  ],
  output: {
    path: path.join(__dirname, "./src", "./../public"),
    filename: "index.js"
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ["babel-loader"]
      },
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader"]
      }
    ]
  },
  devtool: "inline-source-map",
  devServer: {
    contentBase: __dirname + "/src/",
    hot: true,
    headers: {
      "Access-Control-Allow-Origin": "*"
    },
    historyApiFallback: true,
    proxy: {
      "/react/php/komus_new/test.php": {
        target: "http://localhost:80"
      }
    }
  },
  plugins: [
    new CleanWebpackPlugin(),
    new HtmlWebpackPlugin({
      title: "Hot Module Replacement",
      template: "./src/index.html"
    })
  ]
};
