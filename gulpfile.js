const gulp = require('gulp')
const {src, dest, watch} = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const sourcemaps = require('gulp-sourcemaps')
const browserSync = require('browser-sync')
const uglify = require('gulp-uglify')
const minifyCss = require('gulp-clean-css')
const rename = require("gulp-rename")
const plumber = require('gulp-plumber');

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
        .pipe(minifyCss({
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
    return src(`${pathSrc}/scss/vendors/bootstrap.scss`)
        .pipe(plumber({
            errorHandler: function (err) {
                console.error(err.message);
                this.emit('end');
            }
        }))
        .pipe(sass({
            outputStyle: 'expanded',
            includePaths: ['node_modules'],
            quietDeps: true
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathDist}/libs/bootstrap/`))
        .pipe(browserSync.stream())
}

// Task build js bootstrap
function buildLibsBootstrapJS() {
    return src( `${pathNodeModule}/bootstrap/dist/js/bootstrap.bundle.js`, {allowEmpty: true} )
        .pipe(uglify())
        .pipe(rename( {suffix: '.min'} ))
        .pipe(dest(`${pathDist}/libs/bootstrap/`))
        .pipe(browserSync.stream())
}

/*
Task build owl carousel
* */
function buildStyleOwlCarousel() {
    return src(`${pathNodeModule}/owl.carousel/dist/assets/owl.carousel.css`)
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathDist}/libs/owl.carousel/`))
        .pipe(browserSync.stream())
}

function buildJsOwlCarouse() {
    return src([
        `${pathNodeModule}/owl.carousel/dist/owl.carousel.js`
    ], {allowEmpty: true})
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathDist}/libs/owl.carousel/`))
        .pipe(browserSync.stream())
}

// Task build style theme
function buildStyleTheme() {
    return src(`${pathSrc}/scss/style-theme.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded',
            // Tắt cảnh báo deprecated
            sassOptions: {
                quietDeps: true
            }
        }, '').on('error', sass.logError))
        .pipe(dest(`${pathDist}/css/`))
        .pipe(minifyCss({
            level: {1: {specialComments: 0}}
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(`${pathDist}/css/`))
        .pipe(browserSync.stream())
}

exports.buildStyleTheme = buildStyleTheme

function buildJSTheme() {
    return src([
        `${pathSrc}/js/custom.js`,
    ], {allowEmpty: true})
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(dest(`${pathDist}/js/`))
        .pipe(browserSync.stream())
}

// Task build elementor addons
function buildStyleElementor() {
    return src(`${pathSrc}/scss/elementor-addons/addons.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }, '').on('error', sass.logError))
        .pipe(minifyCss({
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
        .pipe(minifyCss({
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
        .pipe(minifyCss({
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
        .pipe(minifyCss({
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