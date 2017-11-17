## Contributing

### Theme Contributions

_Coming soon_

### Documentation

The documentation for Primer theme is auto-generated using [APIgen](http://www.apigen.org/) and [Sphinx](http://www.sphinx-doc.org/) and get re-built each time a new version of Primer is released.

Building the documentation is easy using the bundled Grunt tasks.

From the **theme root** you can use the following command to generate the documentation.

```bash
$ grunt update-docs
```

The dependencies will be installed and the documentation will be built and compiled into the `/documentation/build/html/` directory. Feel free to preview the documentation before pushing changes live to the site.

When you are happy with the changes, the documentation can be deployed using:

```bash
$ grunt deploy-docs
```

Once completed your changes should immediately be visible at [https://godaddy.github.io/wp-primer-theme/index.html](https://godaddy.github.io/wp-primer-theme/index.html)

### Tutorials

Writing a tutorial for Primer is easy. Create an `.md` file inside of `.dev/docs/sphinx/src/tutorials-and-examples/tutorials/` and add it to the list in `.dev/docs/sphinx/src/how-to.rst`.

### Notable Quirks

#### Sphinx cache:

If you previously created a file and re-built the documentation using `$ grunt update-docs` your files may be cached inside of `.dev/docs/sphinx/src/build/doctrees/`. This can cause some issues if you change a file name and re-build the docs a second time

For example, if you setup `page-a.md` and do `$ grunt update-docs` then realize the name is incorrect, when you change the name to `page-b.md` and re-run `$ grunt update-docs` you will find that you end up with a `page-a.html` and a `page-b.html`.

To resolve this issue - head into `.dev/docs/sphinx/src/build/doctrees/` and delete `page-a.doctree`, and then re-build the documentation. You may also need to delete the related `page-a.html` file inside of `.dev/docs/build/html/`.
