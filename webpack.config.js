const path = require('path');
const webpack = require('webpack');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

module.exports = {
    entry: {
        'home/home-index': './templates/home/home-index.js',
        'dashboard/dashboard': './templates/dashboard/dashboard.js',
        'register/register': './templates/register/register.js',
        'layout/layout': './templates/layout/layout.js',

        // here you can add more entries for each page or global assets like jQuery and bootstrap
        // 'layout/layout': './templates/layout/layout.js'
    },
    output: {
        path: path.resolve(__dirname, 'public/assets'),
    },
    optimization: {
        minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
    },
    performance: {
        maxEntrypointSize: 1024000,
        maxAssetSize: 1024000
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader']
            }
        ],
    },
    plugins: [
        new CleanWebpackPlugin(),
        new ManifestPlugin(),
        new MiniCssExtractPlugin({
            ignoreOrder: false
        }),
    ],
    watchOptions: {
        ignored: ['./node_modules/']
    },
    mode: "development"
};