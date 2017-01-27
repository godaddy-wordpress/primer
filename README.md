## Primer Theme Documentation

https://godaddy.github.io/wp-primer-theme/index.html

### How To

The documentation for Primer theme is auto-generated using [APIgen](http://www.apigen.org/) and [Sphinx](http://www.sphinx-doc.org/) and get re-built each time a new version of Primer is released.

Building the documentation is easy using the bundled Grunt.js tasks.

From the **theme root** the following command is used to generate documentation.

```bash
$ grunt docs
```

The documentation will be built and compiled into the `/documentation/build/html/en` directory. Feel free to preview the documentation before pushing changes live to the site.

When you are happy with the changes, the documentation can be deployed using:

```bash
$ grunt deploy-docs
```

Once completed your changes should immediately be visible at https://godaddy.github.io/wp-primer-theme/index.html
