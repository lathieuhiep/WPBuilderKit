const gulp = require('gulp')
const {src, dest, watch} = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const sourcemaps = require('gulp-sourcemaps')
const browserSync = require('browser-sync')
const uglify = require('gulp-uglify')
const cleanCSS  = require('gulp-clean-css')
const rename = require("gulp-rename")
const plumber = require('gulp-plumber');
const path = require('path');

// Đường dẫn file
const paths = {
    node_modules: 'node_modules',
    theme: {
        scss: 'src/theme/scss/',
        js: 'src/theme/js/'
    },
    plugins: {
        root: 'src/plugins/',
        essentialsForBasic: {
            scss: 'src/plugins/essentials-for-basic/scss/',
            js: 'src/plugins/essentials-for-basic/js/'
        }
    },
    shared: {
        libs: 'src/shared/libs/',
        scss: 'src/shared/scss/'
    },
    output: {
        theme: {
            root: 'dist/theme/basictheme/assets/',
            css: 'dist/theme/basictheme/assets/css/',
            js: 'dist/theme/basictheme/assets/js/',
            libs: 'dist/theme/basictheme/assets/libs/'
        },
        plugins: {
            root: 'dist/plugins/',
            essentialsForBasic: 'dist/plugins/essentials-for-basic/assets/'
        }
    }
};

const pathSrc = './src'
const pathDist = './assets'
const pathNodeModule = './node_modules'

// server
// tạo file .env với biến PROXY="localhost/basicthem". Có thể thay đổi giá trị này.
require('dotenv').config()
const proxy = process.env.PROXY || "localhost/basicthem";
function server() {
    browserSync.init({
        proxy: proxy,
        open: false,
        cors: true,
        ghostMode: false
    })
}

/*
Task build fontawesome
* */
function buildFontawesomeStyle() {
    return src(`${pathSrc}/scss/vendors/fontawesome.scss`)
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules']
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathDist}/libs/fontawesome/css`))
        .pipe(browserSync.stream())
}

function CopyWebFonts() {
    return src([
        './node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.ttf',
        './node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.woff2',
        './node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.ttf',
        './node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2',
        './node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.ttf',
        './node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.woff2',
    ], {encoding: false})
        .pipe(dest(`${pathDist}/libs/fontawesome/webfonts`))
        .pipe(browserSync.stream())
}

exports.CopyWebFonts = CopyWebFonts

/*
Task build Bootstrap
* */

// Task build style bootstrap
function buildStyleBootstrap() {
    return src(`${paths.shared.scss}vendors/bootstrap.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: [
                path.resolve(__dirname, 'node_modules/')
            ],
            quietDeps: true
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${paths.output.theme.libs}bootstrap/`))
        .pipe(browserSync.stream())
}

// Task build js bootstrap
function buildLibsBootstrapJS() {
    return src( `${paths.node_modules}/bootstrap/dist/js/bootstrap.bundle.js`, {allowEmpty: true} )
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in buildLibsBootstrapJS:', err.message);
                this.emit('end');
            }
        }))
        .pipe(uglify())
        .pipe(rename( {suffix: '.min'} ))
        .pipe(dest(`${paths.output.theme.libs}/bootstrap/`))
        .pipe(browserSync.stream())
}

/*
Task build owl carousel
* */
function buildStyleOwlCarousel() {
    return src(`${paths.node_modules}/owl.carousel/dist/assets/owl.carousel.css`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(sass({
            outputStyle: 'expanded',
            quietDeps: true
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${paths.output.theme.libs}owl.carousel/`))
        .pipe(browserSync.stream())
}

function buildJsOwlCarouse() {
    return src(`${paths.node_modules}/owl.carousel/dist/owl.carousel.js`, {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in buildLibsOwlCarouseJS:', err.message);
                this.emit('end');
            }
        }))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${paths.output.theme.libs}owl.carousel/`))
        .pipe(browserSync.stream())
}

// Task build style theme
function buildStyleTheme() {
    return src(`${paths.theme.scss}style-theme.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(dest(`${paths.output.theme.css}`))
        .pipe(cleanCSS ({
            level: 2
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(`${paths.output.theme.css}`))
        .pipe(browserSync.stream())
}

function buildJSTheme() {
    return src(`${paths.theme.js}*.js`, {allowEmpty: true})
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('Error in build js in theme:', err.message);
                this.emit('end');
            }
        }))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${paths.output.theme.js}`))
        .pipe(browserSync.stream())
}

// Task build elementor addons
function buildStyleElementor() {
    return src(`${pathSrc}/scss/elementor-addons/addons.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(`./extension/elementor-addon/css/`))
        .pipe(browserSync.stream())
}

function buildJSElementor() {
    return src([
        `${pathSrc}/js/elementor-addon.js`,
    ], {allowEmpty: true})
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`./extension/elementor-addon/js/`))
        .pipe(browserSync.stream())
}

// Task build style custom post type
function buildStyleCustomPostType() {
    return src(`${pathSrc}/scss/post-type/*/**.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(`${pathDist}/css/post-type/`))
        .pipe(browserSync.stream())
}

// Task build style page templates
function buildStylePageTemplate() {
    return src(`${pathSrc}/scss/page-templates/*.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(`${pathDist}/css/page-templates/`))
        .pipe(browserSync.stream())
}

// Task build style shop
function buildStyleShop() {
    return src(`${pathSrc}/scss/shop/shop.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(cleanCSS ({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(`./extension/woocommerce/assets/css/`))
        .pipe(browserSync.stream())
}
exports.buildStyleShop = buildStyleShop

/*
Task build project
* */
async function buildProject() {
    await buildStyleBootstrap()
    await buildLibsBootstrapJS()

    await buildFontawesomeStyle()
    await CopyWebFonts()

    await buildStyleOwlCarousel()
    await buildJsOwlCarouse()

    await buildStyleTheme()
    await buildJSTheme()

    await buildStyleElementor()
    await buildJSElementor()

    await buildStyleCustomPostType()

    await buildStylePageTemplate()
}

exports.buildProject = buildProject

// Task watch
function watchTask() {
    server()

    watch([
        `${pathSrc}/scss/abstracts/*/**.scss`
    ], gulp.series(
        buildStyleBootstrap,
        buildStyleTheme,
        buildStyleElementor,
        buildStyleCustomPostType,
        buildStylePageTemplate
    ))

    watch([
        `${pathSrc}/scss/vendors/bootstrap.scss`
    ], buildStyleBootstrap)

    watch([
        `${pathSrc}/scss/base/*.scss`,
        `${pathSrc}/scss/utilities/*.scss`,
        `${pathSrc}/scss/components/*.scss`,
        `${pathSrc}/scss/layout/*.scss`,
        `${pathSrc}/scss/style-theme.scss`,
    ], buildStyleTheme)
    watch([`${pathSrc}/js/custom.js`], buildJSTheme)

    watch([
        `${pathSrc}/scss/elementor-addons/*.scss`
    ], buildStyleElementor)
    watch([`${pathSrc}/js/elementor-addon.js`], buildJSElementor)

    watch([
        `${pathSrc}/scss/post-type/*/**.scss`
    ], buildStyleCustomPostType)

    watch([
        `${pathSrc}/scss/page-templates/*.scss`
    ], buildStylePageTemplate)

    watch([
        './*.php',
        './**/*.php',
        `${pathDist}/images/**/*`
    ], browserSync.reload);
}

exports.watchTask = watchTask