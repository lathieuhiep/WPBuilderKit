const gulp = require('gulp')
const {src, dest, watch} = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const sourcemaps = require('gulp-sourcemaps')
const browserSync = require('browser-sync')
const uglify = require('gulp-uglify')
const cleanCSS = require('gulp-clean-css')
const rename = require("gulp-rename")
const gulpIf = require('gulp-if');
const plumber = require('gulp-plumber');
const webpack = require('webpack');
const webpackStream = require('webpack-stream');
const TerserPlugin = require('terser-webpack-plugin');
const glob = require('glob');
const path = require('path');

require('dotenv').config()

// setting NODE_ENV: development or production
// NODE_ENV="development" trong file .env để chạy ở chế độ phát triển (có sourcemap)
const isDev = (process.env.NODE_ENV === 'development');

// server
// tạo file .env với biến PROXY="localhost/basictheme". Có thể thay đổi giá trị này.
const proxy = process.env.PROXY || "localhost/basictheme";

const server = () => {
    browserSync.init({
        proxy: proxy,
        open: false,
        cors: true,
        ghostMode: false
    })
}

// Biến đại diện cho tên plugin và theme
const pluginNameEFA = 'essential-features-addon';

// function build scss pipeline
const buildScssPipeline = ({ input, output, includePaths = ['node_modules', 'src'] }) => {
    return src(input)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: includePaths
        }).on('error', sass.logError))
        .pipe(cleanCSS({ level: 2 }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(output))
        .pipe(browserSync.stream());
};

// function buildJSPipeline
const buildJsPipeline = ({ input, output, label = 'JS Pipeline' }) => {
    return src(input, { allowEmpty: true })
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(`Error in build JS in ${label}:`, err.message);
                this.emit('end');
            }
        }))
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest(output))
        .pipe(browserSync.stream());
}

/**
 * ---------------------------
 * Build Plugins
 * ---------------------------
 */

// function make plugin paths
const makePluginPaths = (slug) => {
    const root = `src/plugins/${slug}`;
    const dist = `plugins/${slug}/assets`;

    return {
        input: {
            scss: `${root}/scss/`,
            js: `${root}/js/`
        },
        output: {
            css: `${dist}/css/`,
            js: `${dist}/js/`
        }
    };
}

/** Plugin Extend Site paths */
const pathPluginES = makePluginPaths('extend-site');

/** Task build style custom login */
const pluginEsBuildStyleCustomLogin = () => {
    return buildScssPipeline({
        input: `${pathPluginES.input.scss}custom-login.scss`,
        output: `${pathPluginES.output.css}be/`
    })
}

/** Task build style addons */
const pluginEsBuildStyleAddons = () => {
    return buildScssPipeline({
        input: `${pathPluginES.input.scss}addons-elementor.scss`,
        output: `${pathPluginES.output.css}fe/`
    })
}

/** Task build style custom post type */
const pluginEsBuildStyleCPT = () => {
    return buildScssPipeline({
        input: `${pathPluginES.input.scss}cpt/**/*.scss`,
        output: `${pathPluginES.output.css}fe/cpt/`
    })
}

/** Task build js plugin extend site */
const pluginEsBuildJs = () => {
    return buildJsPipeline({
        input: `${pathPluginES.input.js}*/**.js`,
        output: `${pathPluginES.output.js}`
    })
}

/** Watch all plugin extend site */
const pluginEsWatchAll = () => {
    watch([
        `${pathPluginES.input.scss}abstracts/*.scss`,
        `${pathPluginES.input.scss}base/*.scss`,
        `${pathPluginES.input.scss}components/*.scss`,
    ], gulp.series(
        pluginEsBuildStyleAddons,
        pluginEsBuildStyleCPT
    ))

    watch([
        `${pathPluginES.input.scss}custom-login.scss`
    ], pluginEsBuildStyleCustomLogin)

    watch([
        `${pathPluginES.input.scss}addons/*.scss`,
        `${pathPluginES.input.scss}addons-elementor.scss`
    ], pluginEsBuildStyleAddons)

    watch([
        `${pathPluginES.input.scss}cpt/**/*.scss`
    ], pluginEsBuildStyleCPT)

    watch([
        `${pathPluginES.input.js}*/**.js`
    ], pluginEsBuildJs)
}

/** ---------------------------
 * Build vendors
 * ---------------------------
 */
const themeName = 'basictheme';

// function make vendor paths
const makeVendorPaths = (slug) => {
    const root = `src/vendors/${slug}`;
    const dist = `themes/${themeName}/assets/vendors/${slug}`;

    return {
        input: `${root}/`,
        output: `${dist}/`
    };
}

const pathVendorBootstrap = makeVendorPaths('bootstrap');

/** task build style custom bootstrap */
const buildStyleCustomBootstrap = () => {
    return buildScssPipeline({
        input: `${pathVendorBootstrap.input}*.scss`,
        output: `${pathVendorBootstrap.output}`
    })
}

/** task build js custom bootstrap */
const buildJSCustomBootstrap = () => {
    return src([
        `${pathVendorBootstrap.input}*.js`
    ], {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in build js bootstrap:', err.message);
                this.emit('end');
            }
        }))
        .pipe(webpackStream({
            mode: 'production',
            output: {
                filename: 'custom-bootstrap.min.js'
            },
            module: {
                rules: [
                    {
                        test: /\.m?js$/,
                        exclude: /node_modules/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            resolve: {
                extensions: ['.js']
            },
            optimization: {
                minimize: true,
                minimizer: [
                    new TerserPlugin({
                        extractComments: false,
                        terserOptions: {
                            format: {
                                comments: false
                            },
                        },
                    })
                ]
            }
        }))
        .pipe(dest(`${pathVendorBootstrap.output}`))
        .pipe(browserSync.stream())
}

const vendorWatchAll = () => {
    watch([
        `${pathVendorBootstrap.input}*.scss`
    ], buildStyleCustomBootstrap)

    watch([
        `${pathVendorBootstrap.input}*.js`
    ], buildJSCustomBootstrap)
}

/** ---------------------------
 * Build Theme
 * ---------------------------
 */

// function make theme paths
const makeThemePaths = () => {
    const root = `src/theme`;
    const dist = `themes/${themeName}/assets`;

    return {
        input: {
            scss: `${root}/scss/`,
            js: `${root}/js/`
        },
        output: {
            css: `${dist}/css/`,
            js: `${dist}/js/`
        },
        woo: {
            css: `themes/${themeName}/includes/woocommerce/assets/css/`,
            js: `themes/${themeName}/includes/woocommerce/assets/js/`
        }
    };
}

/** Theme paths */
const pathTheme = makeThemePaths();

/** Task build style theme */
const buildStyleTheme = () => {
    return buildScssPipeline({
        input: `${pathTheme.input.scss}main.scss`,
        output: `${pathTheme.output.css}`
    })
}

/** Task build style custom post type */
const buildStyleCustomPostType = () => {
    return buildScssPipeline({
        input: `${pathTheme.input.scss}post-type/**/*.scss`,
        output: `${pathTheme.output.css}post-type/`
    })
}

/** Task build style page template */
const buildStylePageTemplate = () => {
    return buildScssPipeline({
        input: `${pathTheme.input.scss}page-templates/*.scss`,
        output: `${pathTheme.output.css}page-templates/`
    })
}

/** Task build js theme */
const buildJSTheme = () => {
    return src([
        `${pathTheme.input.js}*.js`
    ], {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in build js in theme:', err.message);
                this.emit('end');
            }
        }))
        .pipe(webpackStream({
            mode: 'production',
            output: {
                filename: 'main.min.js'
            },
            module: {
                rules: [
                    {
                        test: /\.m?js$/,
                        exclude: /node_modules/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            resolve: {
                extensions: ['.js']
            },
            optimization: {
                minimize: true,
                minimizer: [
                    new TerserPlugin({
                        extractComments: false,
                        terserOptions: {
                            format: {
                                comments: false
                            },
                        },
                    })
                ]
            }
        }))
        .pipe(dest(`${pathTheme.output.js}`))
        .pipe(browserSync.stream())
}

/** Task build style shop */
const buildStyleShop = () => {
    return buildScssPipeline({
        input: `${pathTheme.input.scss}shop/*.scss`,
        output: `${pathTheme.woo.css}`
    })
}

/** Task build js shop */
const buildJSShop = () => {
    const entries = glob.sync(`${pathTheme.input.js}shop/*.js`).reduce((result, file) => {
        const name = path.basename(file, '.js');
        result[name] = './' + file.replace(/\\/g, '/');
        return result;
    }, {});

    return src(`${pathTheme.input.js}shop/*.js`, { allowEmpty: true })
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in buildJSShop:', err.message);
                this.emit('end');
            }
        }))
        .pipe(webpackStream({
            mode: 'production',
            entry: entries,
            output: {
                filename: '[name].min.js',
            },
            module: {
                rules: [
                    {
                        test: /\.m?js$/,
                        exclude: /node_modules/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            resolve: {
                extensions: ['.js']
            },
            optimization: {
                minimize: true,
                minimizer: [
                    new TerserPlugin({
                        extractComments: false,
                        terserOptions: {
                            format: {
                                comments: false
                            },
                        },
                    })
                ]
            }
        }, webpack))
        .pipe(dest(`${pathTheme.woo.js}`))
        .pipe(browserSync.stream());
}

/** Watch Shared build style */
const buildWatchShared = () => {
    watch([
        `src/shared/scss/**/*.scss`
    ], gulp.series(
        pluginEsBuildStyleCustomLogin,
        pluginEsBuildStyleAddons,
        pluginEsBuildStyleCPT,

        buildStyleCustomBootstrap,
        buildStyleTheme,
        buildStyleCustomPostType,
        buildStylePageTemplate,
        buildStyleShop
    ))
}

/** Watch all theme */
const themeWatchAll = () => {
    watch([
        `${pathTheme.input.scss}base/*.scss`,
        `${pathTheme.input.scss}utilities/*.scss`,
        `${pathTheme.input.scss}components/*.scss`,
        `${pathTheme.input.scss}layout/*.scss`,
        `${pathTheme.input.scss}main.scss`,
    ], buildStyleTheme)

    watch([
        `${pathTheme.input.scss}post-type/**/*.scss`
    ], buildStyleCustomPostType)

    watch([
        `${pathTheme.input.scss}page-templates/*.scss`
    ], buildStylePageTemplate)

    watch([
        `${pathTheme.input.scss}shop/abstracts/*.scss`,
        `${pathTheme.input.scss}shop/components/*.scss`,
        `${pathTheme.input.scss}shop/*.scss`
    ], buildStyleShop)

    watch([`${pathTheme.input.js}*.js`], buildJSTheme)

    watch([
        `${pathTheme.input.js}shop/components/*.js`,
        `${pathTheme.input.js}shop/*.js`
    ], buildJSShop)
}

/*
Task build project
* */
const buildProject = async () => {
    // Chạy các plugin styles song song
    await Promise.all([
        pluginEsBuildStyleCustomLogin(),
        pluginEsBuildStyleAddons(),
        pluginEsBuildJs(),
    ]);

    // Chạy vendors style và các theme styles/JS song song
    await Promise.all([
        buildStyleCustomBootstrap(),
        buildStyleTheme(),
        buildStyleCustomPostType(),
        buildStylePageTemplate(),
        buildStyleShop(),
        buildJSCustomBootstrap(),
        buildJSTheme(),
        buildJSShop(),
    ]);

    console.log("Dự án đã được xây dựng hoàn tất!");
}
exports.buildProject = buildProject

// Task watch
const watchTask = () => {
    server()

    // watch plugins extend site
    pluginEsWatchAll()

    // watch vendors
    vendorWatchAll()

    // watch shared styles
    buildWatchShared()

    // watch theme
    themeWatchAll()
}
exports.watchTask = watchTask