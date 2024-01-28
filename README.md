
# Theme for ImmediateEdges Website

Before start, make sure you have installed IE Docker setup.

* [Installing the Theme](#installing-the-theme)
* [Local development](#local-development)
* [Build production-ready files](#build-production-ready-files)

---

## Installing the Theme

1. Clone repo directly into `/themes/` directory inside docker setup root folder.
2. Run `composer install` in the theme root folder to install PHP and WordPress plugins theme dependencies.
3. Run `npm i` in the theme root folder to install NodeJS theme dependecies.
4. Build local bundle using command `npm run build:local`
5. Open `ie.test` in the browser to make sure that everything works fine.

---

## Local development

Once we have installed theme locally and built local bundle, we can speed-up local development by running command `npm start`. It will open a new browser tab with address `localhost:3000` which is proxied to `ie.test`.

Now every time we have changes in CSS, Hot Module Replacement plugin from webpack will replace CSS on the page on fly, without page reload:

Read More about that feature: https://webpack.js.org/concepts/hot-module-replacement/

Also, `browserSync` works for reloading page each time template files were changed.

Bundle files are stored in the `/scratch` folder. Do not use it in the production environment.

---

## Build production-ready files

Just run `npm run build`.

Production-ready files are stored in the `/dist` folder.

The `manifest.json` file will be also generated during build process. It allows to store different versions of the assets files and don't care about users browser cache, once Varnish cached page is expired, all assets will be fetched with their new versions. Before that moment all previous versions of assets are available to be loaded by cached version of the page (except the case if `dist/` folder is replaced each time during the deploy).