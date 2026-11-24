import path from 'path';
import { fileURLToPath } from 'url';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import RemoveEmptyScriptsPlugin from 'webpack-remove-empty-scripts';
import webpack from 'webpack';
import fs from 'fs';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Helper to get block entries
const getBlockEntries = () => {
    const entries = {};
    const blockFiles = fs.readdirSync(path.resolve(__dirname, 'src/scss/blocks'))
        .filter(file => file.startsWith('_') && file.endsWith('.scss'));

    blockFiles.forEach(file => {
        const name = file.slice(1, -5); // Extract 'core-button' from '_core-button.scss'
        entries[`assets/styles/${name}`] = `./src/scss/blocks/${file}`;
    });

    return entries;
};

export default (env, argv) => {
    const isProd = argv.mode === 'production';

    return {
        entry: {
            'style': './src/scss/style.scss',
            'assets/js/theme-toggle': './src/js/main.js',
            'assets/js/edd-cart-feedback': './src/js/edd-cart-feedback.js',
            'assets/js/edd-product-price': './src/js/edd-product-price.js',
            'assets/js/product-bindings': './src/js/product-bindings.js',
            'assets/js/edd-account': './src/js/edd-account.js',
            'assets/js/button-icon-editor': './src/extensions/button-icon/index.js',
            'assets/styles/button-icon-editor': './src/extensions/button-icon/editor.scss',
            'assets/styles/admin-welcome': './src/scss/admin/welcome.scss',
            ...getBlockEntries(),
        },
        output: {
            path: path.resolve(__dirname, '.'),
            filename: '[name].js',
            clean: false,
        },
        externals: {
            '@wordpress/blocks': ['wp', 'blocks'],
            '@wordpress/block-editor': ['wp', 'blockEditor'],
            '@wordpress/components': ['wp', 'components'],
            '@wordpress/compose': ['wp', 'compose'],
            '@wordpress/element': ['wp', 'element'],
            '@wordpress/hooks': ['wp', 'hooks'],
            '@wordpress/i18n': ['wp', 'i18n'],
        },
        module: {
            rules: [
                {
                    test: /\.jsx?$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                '@babel/preset-env',
                                ['@babel/preset-react', {
                                    pragma: 'wp.element.createElement',
                                    pragmaFrag: 'wp.element.Fragment',
                                }],
                            ],
                        },
                    },
                },
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'postcss-loader',
                        'sass-loader',
                    ],
                },
            ],
        },
        plugins: [
            new RemoveEmptyScriptsPlugin(),
            new MiniCssExtractPlugin({
                filename: '[name].css',
            }),
            new webpack.BannerPlugin({
                banner: () => {
                    return fs.readFileSync(path.resolve(__dirname, 'style.css'), 'utf8')
                        .match(/\/\*[\s\S]*?\*\//)[0];
                },
                raw: true,
                entryOnly: true,
                include: /style\.css$/,
            }),
        ],
        stats: 'minimal',
        devtool: isProd ? 'source-map' : 'inline-source-map',
    };
};
