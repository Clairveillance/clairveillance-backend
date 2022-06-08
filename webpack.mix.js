const mix = require("laravel-mix");
let minifier = require("minifier");

mix
  .setPublicPath(__dirname)
  .setResourceRoot(__dirname)
  .js("src/Interface/resources/js/app.js", "src/Interface/public/js")
  .postCss("src/Interface/resources/css/app.css", "src/Interface/public/css", [
    //
  ])
  .copy("mix-manifest.json", "src/Interface/public/");

if (mix.inProduction()) {
  mix.then(() => {
    minifier.minify(__dirname + "/src/Interface/public/css/app.css");
  });
}
