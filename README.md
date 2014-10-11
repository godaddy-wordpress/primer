## Basis Framework

Basis is a theme framework that embraces modern development workflows.

What it offers:

* Grunt for development automation
	* i18n [grunt-pot](https://www.npmjs.org/package/grunt-pot)
	* Sass compilation with experimental libsass compiler [grunt-sass](https://github.com/sindresorhus/grunt-sass)
	* RTL styles with [CSSJanus](https://code.google.com/p/cssjanus/)
	* Live browser syncing across connected devices over Wi-Fi with [Browser Sync](http://www.browsersync.io)
	* JSHint for testing JavaScript.
* Sass (uses SCSS syntax)
	* Automated WYSIWYG editor styles
	* Foundation grid system
	* Color contrast function from [Compass](http://compass-style.org/)
* WordPress Coding Standards
* Awesome Customizer controls (coming soon)

### Important Things to Note

1. We don't minify and concatenate JavaScript files. Why? Because you shouldn't do this in themes you distribute. Let caching plugins handle it.
2. We use the standard `wp_enqueue_script()` system to declare JavaScript dependencies for the theme. This is a second reason why we don't do #1.
3. All front-end development pre-compiled scripts and styles are stored in a .dev folder which is hidden to
4. Basis supports the following features from Jetpack: infinite scroll, featured content.

### Getting Started with Development

1. Install [Node.js](http://nodejs.org/download/).
2. Install packages by running `npm install` inside theme folder using command prompt.
3. Run Grunt by entering `grunt` into command prompt.
4. Edit files like a boss.