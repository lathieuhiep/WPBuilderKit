const gulp = require('gulp')
const {src, dest, watch} = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const sourcemaps = require('gulp-sourcemaps')
const browserSync = require('browser-sync')
const uglify = require('gulp-uglify')
const cleanCSS = require('gulp-clean-css')
const rename = require("gulp-rename")
const plumber = require('gulp-plumber');
const gulpIf = require('gulp-if');
const webpack = require('webpack-stream');
const TerserPlugin = require('terser-webpack-plugin');

require('dotenv').config()

// setting NODE_ENV: development or production
const isDev = (process.env.NODE_ENV === 'development');

// Biến đại diện cho tên plugin và theme
const pluginNameEFA = 'essential-features-addon';
const themeName = 'basictheme';

// Đường dẫn file
const paths = {
    node_modules: 'node_modules/',
    theme: {
        scss: 'src/theme/scss/',
        js: 'src/theme/js/'
    },
    plugins: {
        root: 'src/plugins/',
        efa: {
            scss: `src/plugins/${pluginNameEFA}/scss/`,
            js: `src/plugins/${pluginNameEFA}/js/`
        }
    },
    shared: {
        scss: 'src/shared/scss/',
        vendors: 'src/shared/scss/vendors/',
    },
    output: {
        theme: {
            root: `themes/${themeName}/assets/`,
            css: `themes/${themeName}/assets/css/`,
            js: `themes/${themeName}/assets/js/`,
            libs: `themes/${themeName}/assets/libs/`,
            woo: `themes/${themeName}/includes/woocommerce/assets/`
        },
        plugins: {
            root: 'plugins/',
            efa: {
                css: `plugins/${pluginNameEFA}/assets/css/`,
                js: `plugins/${pluginNameEFA}/assets/js/`,
                libs: `plugins/${pluginNameEFA}/assets/libs/`
            }
        }
    }
};

// server
// tạo file .env với biến PROXY="localhost/basictheme". Có thể thay đổi giá trị này.
const proxy = process.env.PROXY || "localhost/basictheme";

function server() {
    browserSync.init({
        proxy: proxy,
        open: false,
        cors: true,
        ghostMode: false
    })
}

// Task build style theme
function buildStyleTheme() {
    return src(`${paths.theme.scss}style-theme.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('SCSS Style Theme Error:', err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules', 'src']
        }, '').on('error', sass.logError))

        // --- Xuất file chưa min ---
        .pipe(rename({suffix: '.bundle'}))
        .pipe(dest(`${paths.output.theme.css}`))

        // --- Tạo bản minified ---
        .pipe(cleanCSS({level: 2}))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(`${paths.output.theme.css}`))
        .pipe(browserSync.stream())
}
exports.buildStyleTheme = buildStyleTheme

function buildJSTheme() {
    return src([
        `${paths.theme.js}*.js`
    ], {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in build js in theme:', err.message);
                this.emit('end');
            }
        }))
        .pipe(webpack({
            mode: 'production',
            output: {
                filename: 'main.bundle.min.js'
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
        .pipe(dest(`${paths.output.theme.js}`))
        .pipe(browserSync.stream())
}

// Task build style custom post type
function buildStyleCustomPostType() {
    return src(`${paths.theme.scss}post-type/*/**.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules', 'src']
        }, '').on('error', sass.logError))
        .pipe(cleanCSS({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(`${paths.output.theme.css}post-type/`))
        .pipe(browserSync.stream())
}

// Task build style page templates
function buildStylePageTemplate() {
    return src(`${paths.theme.scss}page-templates/*.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules', 'src']
        }, '').on('error', sass.logError))
        .pipe(cleanCSS({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(`${paths.output.theme.css}page-templates/`))
        .pipe(browserSync.stream())
}

// Task build style shop
function buildStyleShop() {
    return src(`${paths.theme.scss}shop/*.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('SCSS Shop Error:', err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules', 'src']
        }, '').on('error', sass.logError))

        // --- Xuất file chưa min ---
        .pipe(dest(`${paths.output.theme.woo}css/`))

        // --- Tạo bản minified ---
        .pipe(cleanCSS({level: 2}))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(`${paths.output.theme.woo}css/`))
        .pipe(browserSync.stream())
}

function buildJSShop() {
    return src(`${paths.theme.js}shop/*.js`, {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in build js in shop:', err.message);
                this.emit('end');
            }
        }))
        .pipe(webpack({
            mode: 'production',
            output: {
                filename: 'woo-quick-view.min.js'
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
        .pipe(dest(`${paths.output.theme.woo}js/`))
        .pipe(browserSync.stream())
}

/*
** Plugin
* */

// Task build style elementor addons
function buildStyleElementor() {
    return src(`${paths.plugins.efa.scss}efa-elementor.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules', 'src']
        }, '').on('error', sass.logError))
        .pipe(cleanCSS({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(`${paths.output.plugins.efa.css}`))
        .pipe(browserSync.stream())
}

// Task build style custom login
function buildStyleCustomLogin() {
    return src(`${paths.plugins.efa.scss}efa-custom-login.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules', 'src']
        }, '').on('error', sass.logError))
        .pipe(cleanCSS({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(dest(`${paths.output.plugins.efa.css}`))
        .pipe(browserSync.stream())
}

function buildJPluginEFA() {
    return src(`${paths.plugins.efa.js}*.js`, {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in build js in plugin EFA:', err.message);
                this.emit('end');
            }
        }))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${paths.output.plugins.efa.js}`))
        .pipe(browserSync.stream())
}

/*
Task build project
* */
async function buildProject() {
    // plugin
    await buildStyleCustomLogin()
    await buildStyleElementor()

    await buildJPluginEFA()

    // theme
    await buildStyleTheme()
    await buildStyleCustomPostType()
    await buildStylePageTemplate()
    await buildStyleShop()

    await buildJSTheme()
    await buildJSShop()
}

exports.buildProject = buildProject

// Task watch
function watchTask() {
    server()

    // watch abstracts
    watch([
        `${paths.shared.scss}abstracts/*.scss`
    ], gulp.series(
        buildStyleTheme,
        buildStyleElementor,
        buildStyleCustomLogin,
        buildStyleCustomPostType,
        buildStylePageTemplate,
        buildStyleShop
    ))

    // plugin essentials watch
    watch([
        `${paths.plugins.efa.scss}abstracts/*.scss`,
        `${paths.plugins.efa.scss}addons/*.scss`,
        `${paths.plugins.efa.scss}base/*.scss`,
        `${paths.plugins.efa.scss}components/*.scss`,
        `${paths.plugins.efa.scss}efa-elementor.scss`
    ], buildStyleElementor)

    watch([
        `${paths.plugins.efa.scss}efa-custom-login.scss`
    ], buildStyleCustomLogin)

    watch([`${paths.plugins.efa.js}*.js`], buildJPluginEFA)

    // theme watch
    watch([
        `${paths.theme.scss}vendors/bootstrap.scss`,
        `${paths.theme.scss}base/*.scss`,
        `${paths.theme.scss}utilities/*.scss`,
        `${paths.theme.scss}components/*.scss`,
        `${paths.theme.scss}layout/*.scss`,
        `${paths.theme.scss}style-theme.scss`,
    ], buildStyleTheme)

    watch([
        `${paths.theme.scss}post-type/*/**.scss`
    ], buildStyleCustomPostType)

    watch([
        `${paths.theme.scss}page-templates/*.scss`
    ], buildStylePageTemplate)

    watch([
        `${paths.theme.scss}shop/*.scss`
    ], buildStyleShop)

    watch([`${paths.theme.js}*.js`], buildJSTheme)
    watch([`${paths.theme.js}shop/*.js`], buildJSShop)
}

exports.watchTask = watchTask