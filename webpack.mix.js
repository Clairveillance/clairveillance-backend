const mix = require("laravel-mix");
const path = require("path");

// NOTE: We set custom public path.
mix.setPublicPath(path.resolve(__dirname, "src/Interface/public"));

mix.js("resources/js/app.js", "js").postCss("resources/css/app.css", "css", [
  //
]);
