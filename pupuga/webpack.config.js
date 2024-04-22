//yarn add autoprefixer @babel/core @babel/preset-env babel-loader clean-webpack-plugin cross-env css-loader cssnano extract-text-webpack-plugin@4.0.0-beta.0 file-loader image-webpack-loader jquery node-sass optimize-css-assets-webpack-plugin postcss-loader sass-loader style-loader svg-sprite-loader url-loader vue-loader vue-template-compiler webpack webpack-cli -D
'use strict';

let srcDir = './assets/src/';
let distDir = 'assets/dist/';

/**
 * configuration of points
 */
const points = {
    modules: [
        'bootstrap/main',
        'bootstrap/skeleton',
        'bootstrap/login',
        'bootstrap/admin',
        'tinymce/table'
    ],
    custom: [
        'js/main/calico-lessons',
    ]
};

/**
 * require plugins
 */
const path = require('path');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');


/**
 * production mode on or off
 */
const production = (process.env.NODE_ENV === 'production');


/**
 * plugins configuration
 */
const pluginsCommon = [
    new CleanWebpackPlugin(distDir, { exclude: ['plugins'], verbose: true }),
    new webpack.DefinePlugin({
        PRODUCTION: JSON.stringify(production)
    }),
    new ExtractTextPlugin('[name].css'),
    new SpriteLoaderPlugin({plainSprite: true}),
    new VueLoaderPlugin()
];
const pluginsDeveloping = [];
const pluginsProduction = [
    new OptimizeCssAssetsPlugin()
];

module.exports = {

    mode: process.env.NODE_ENV,

    /**
     * source js files
     */
    entry: function () {
        let entry = {};
        for (let folder in points) {
            points[folder].map(function (item) {
                let src = srcDir + folder + '/' + item;
                let dist = distDir + item.replace('bootstrap/', '').replace('js/', '').replace(new RegExp('/','g'), '-');
                entry[dist] = src;
            });
        }

        return entry;
    }(),

    /**
     * output points js files
     */
    output: {
        path: __dirname,
        filename: '[name].js'
    },


    optimization: {
        /*splitChunks: {
            cacheGroups: {
                commons: {
                    test: /[\\/]node_modules[\\/]/,
                    name: distDir + '/' + 'bundle',
                    chunks: "initial",
                    minSize: 1
                }
            }
        },*/
        minimize: function () {
            return production
        }()
    },


    /**
     *  js source map
     */
    devtool: function () {
        return (production) ? '' : 'source-map'
    }(),

    /**
     * files saving time
     */
    watchOptions: {
        aggregateTimeout: 100
    },

    /**
     *  includes plugins
     */
    plugins: function () {
        return (production) ? pluginsCommon.concat(pluginsProduction) : pluginsCommon.concat(pluginsDeveloping);
    }(),

    /**
     *  includes modules
     */
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                        'scss': ['vue-style-loader','css-loader', 'sass-loader']
                    }
                }
            },
            {
                test: /\.m?js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                       presets: ['@babel/preset-env'] 
                    }
                }
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    publicPath: './',
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader',
                            options: function () {
                                return (production) ? {} : {sourceMap: true}
                            }(),
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: () => [
                                    require('autoprefixer')({
                                        browsers: ['> 0%']
                                    })
                                ],
                                sourceMap: function () {
                                    return !production
                                }(),
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: function () {
                                return (production) ? {} : {sourceMap: true}
                            }(),
                        }
                    ]
                }),
            },
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    publicPath: './',
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader'
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: () => [
                                    require('cssnano')({
                                        preset: ['default', {
                                            discardComments: {
                                                removeAll: true,
                                            },
                                        }],
                                    }),
                                ],
                            }
                        }
                    ]
                }),
            },
            {
                test: /\.svg$/,
                exclude: /(images|fonts)/,
                include: path.resolve(__dirname, srcDir + 'custom/sprite/'),
                loader: 'svg-sprite-loader',
                options: {
                    extract: true,
                    spriteFilename: './' + distDir + 'images/sprite.svg'
                }
            },
            {
                test: /\.(cur)$/,
                use: {
                    loader: 'url-loader',
                    options: {
                        publicPath: '../../',
                        limit: 1,
                        name(file) {
                                return distDir + 'images/' + file.replace('\\', '/').split('/images/')[1];
                        }
                    }
                }
            },
            {
                test: /\.(eot|svg|ttf|woff|woff2)$/,
                exclude: /(images|sprite)/,
                use: {
                    loader: 'file-loader',
                    options: {
                        publicPath: '../../',
                        name: distDir + 'fonts/[name].[ext]'
                    }
                }
            },
            {
                test: /\.(gif|png|jpe?g|svg)$/,
                exclude: /(fonts|sprite)/,
                loaders: [
                    {
                        loader: 'url-loader',
                        options: {
                            publicPath: '../../',
                            limit: 2048,
                            name(file) {
                                return distDir + 'images/' + file.replace('\\', '/').split('/images/')[1];
                            }
                        }
                    },
                ]
            }
        ]
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        },
        extensions: ['.js', '.vue', '.json']
    },
};