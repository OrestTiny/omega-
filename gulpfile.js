const gulp = require("gulp"),
  strip = require("gulp-strip-comments"),
  babel = require("gulp-babel"),
  sass = require("gulp-sass")(require("sass")),
  autoprefixer = require("autoprefixer"),
  size = require("gulp-size"),
  notify = require("gulp-notify"),
  uglify = require("gulp-uglify"), // minify file
  rename = require("gulp-rename"),
  cleanCSS = require("gulp-clean-css"), // remove all comments
  plumber = require("gulp-plumber"), // intercepts errors
  postCSS = require("gulp-postcss"),
  mqpacker = require("css-mqpacker"),
  sortCSSmq = require("sort-css-media-queries"),
  debug = require("gulp-debug"),
  browserSync = require("browser-sync").create();

const domain = "tsigaras";
const domainURL = "http://tsigaras.loc/";

// const domainURL = "http://localhost:8080/";

const path = {
  scss: {
    src: [
      `./${domain}/assets/scss/*.scss`,
      `!./${domain}/assets/scss/gutenberg.scss`,
    ],
    dest: `./${domain}/assets/css`,
  },
  scss_gutenberg: {
    src: [`./${domain}/assets/scss/gutenberg.scss`],
    dest: `./${domain}/assets/css`,
  },
  scss_inner: {
    src: [
      `./${domain}/assets/scss/**/*.scss`,
      `!./${domain}/assets/scss/*.scss`,
    ],
    dest: `./${domain}/assets/css`,
  },
  scss_widgets: {
    src: [`./${domain}/widgets/**/*.scss`],
    dest: `./${domain}/widgets/`,
  },
  js_widgets: {
    src: [`./${domain}/widgets/**/*.js`, `!./${domain}/widgets/**/*.min.js`],
    dest: `./${domain}/widgets/`,
  },
  js: {
    src: [
      `./${domain}/assets/js/**/*.js`,
      `!./${domain}/assets/js/**/*.min.js`,
      `!./${domain}/assets/js/lib{,/**}/*.js`,
    ],
    dest: `./${domain}/assets/js`,
  },
};

const options = {
  mqpacker: { sort: sortCSSmq.desktopFirst },
  size: { title: "Size" },
  rename: { suffix: ".min" },
  cleanCss: {
    level: { 2: { specialComments: 0, restructureRules: true } },
    compatibility: "ie8",
  },
  autoprefixer: ["last 2 version", "> 2%", "ie 6"],
  debug: { title: "Focus:" },
  babel: { presets: ["@babel/env"] },
  sass: { outputStyle: "compressed", includePaths: ["node_modules"] },
  onError: function (err) {
    this.emit("end");
    return notify().write(err);
  },
};

gulp.task("scripts", function () {
  return gulp
    .src(path.js.src)
    .pipe(debug(options.debug))
    .pipe(babel(options.babel))
    .pipe(uglify())
    .pipe(rename(options.rename))
    .pipe(strip())
    .pipe(gulp.dest(path.js.dest))
    .pipe(size(options.size));
});

gulp.task("js_widgets", function () {
  return gulp
    .src(path.js_widgets.src, { since: gulp.lastRun("js_widgets") })
    .pipe(debug(options.debug))
    .pipe(babel(options.babel))
    .pipe(uglify())
    .pipe(strip())
    .pipe(rename(options.rename))
    .pipe(gulp.dest(path.js_widgets.dest))
    .pipe(size(options.size))
    .pipe(browserSync.stream());
});

gulp.task("scss", function () {
  return gulp
    .src(path.scss.src)
    .pipe(debug(options.debug))
    .pipe(sass(options.sass).on("error", options.onError))
    .pipe(cleanCSS(options.cleanCss))
    .pipe(
      postCSS([autoprefixer(options.autoprefixer), mqpacker(options.mqpacker)])
    )
    .pipe(rename({ ...options.rename, dirname: "" }))
    .pipe(gulp.dest(path.scss.dest))
    .pipe(size(options.size));
});

gulp.task("scss_inner", function () {
  return gulp
    .src(path.scss_inner.src)
    .pipe(debug(options.debug))
    .pipe(sass(options.sass).on("error", options.onError))
    .pipe(cleanCSS(options.cleanCss))
    .pipe(
      postCSS([autoprefixer(options.autoprefixer), mqpacker(options.mqpacker)])
    )
    .pipe(rename({ ...options.rename, dirname: "" }))
    .pipe(gulp.dest(path.scss_inner.dest))
    .pipe(size(options.size))
    .pipe(browserSync.stream());
});

gulp.task("scss_widgets", function () {
  return gulp
    .src(path.scss_widgets.src, { since: gulp.lastRun("scss_widgets") })
    .pipe(debug(options.debug))
    .pipe(sass(options.sass).on("error", options.onError))
    .pipe(cleanCSS(options.cleanCss))
    .pipe(
      postCSS([autoprefixer(options.autoprefixer), mqpacker(options.mqpacker)])
    )
    .pipe(rename({ ...options.rename }))
    .pipe(gulp.dest(path.scss_widgets.dest))
    .pipe(size(options.size))
    .pipe(browserSync.stream());
});

gulp.task("scss_gutenberg", function () {
  return gulp
    .src(path.scss_gutenberg.src)
    .pipe(debug(options.debug))
    .pipe(sass(options.sass).on("error", options.onError))
    .pipe(cleanCSS(options.cleanCss))
    .pipe(
      postCSS([autoprefixer(options.autoprefixer), mqpacker(options.mqpacker)])
    )
    .pipe(rename({ ...options.rename, dirname: "" }))
    .pipe(gulp.dest(path.scss.dest))
    .pipe(size(options.size));
});

gulp.task("watch", async () => {
  browserSync.init({
    proxy: domainURL,
  });

  gulp.watch(path.scss.src, gulp.series("scss"));
  gulp.watch(path.scss_gutenberg.src, gulp.series("scss_gutenberg"));
  gulp.watch(path.scss_inner.src, gulp.series("scss_inner"));
  gulp.watch(path.js.src, gulp.series("scripts"));
  gulp.watch(
    path.scss_widgets.src,
    { since: gulp.lastRun("scss_widgets") },
    gulp.series("scss_widgets")
  );
  gulp.watch(
    path.js_widgets.src,
    { since: gulp.lastRun("js_widgets") },
    gulp.series("js_widgets")
  );
});

gulp.task("default", gulp.series("scss_widgets", "js_widgets", "watch"));
