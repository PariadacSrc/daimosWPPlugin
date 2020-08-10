const path = require('path');

module.exports = {
  entry: './src/daim-webpack.js',
  output: {
    filename: 'daim-webpack.js',
    path: path.resolve(__dirname, 'dist'),
  },
};