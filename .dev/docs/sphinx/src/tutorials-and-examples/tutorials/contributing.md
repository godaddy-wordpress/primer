## Contributing

### Theme Contributions

_Coming soon_

### Documentation

The documentation for Primer theme is auto-generated using [APIgen](http://www.apigen.org/) and [Sphinx](http://www.sphinx-doc.org/) and get re-built each time a new version of Primer is released.

Building the documentation is easy using the bundled Grunt tasks.

From the **theme root** you can use the following command to generate the documentation.

```bash
$ grunt docs
```

The dependencies will be installed and the documentation will be built and compiled into the `/documentation/build/html/` directory. Feel free to preview the documentation before pushing changes live to the site.

When you are happy with the changes, the documentation can be deployed using:

```bash
$ grunt deploy-docs
```

Once completed your changes should immediately be visible at [https://godaddy.github.io/wp-primer-theme/index.html](https://godaddy.github.io/wp-primer-theme/index.html)
