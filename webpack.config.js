const path = require("path");
module.exports = {
  entry: path.join(__dirname, "src", "app.js"),
  output: { path: path.join(__dirname, "src", "dist"), filename: "index.js" },
  module: {
    rules: [
      { test: /\.js$/, loader: "babel-loader", exclude: "/node_modules/" }
    ]
  },
  devServer:{
      overlay: true
  }
};
