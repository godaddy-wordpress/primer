## Primer Theme Documentation

https://godaddy.github.io/wp-primer-theme/index.html

### How To

The documentation for Primer theme is auto-generated using [APIgen](http://www.apigen.org/) and [Sphinx](http://www.sphinx-doc.org/) and is built and deployed on each new release of Primer, in the Travis CI pipeline.

Building the documentation is easy using the bundled Grunt tasks.

#### Requirements


###### APIgen v4.0.1

Building the documentation locally requires [APIgen](http://www.apigen.org/) v4.0.1. APIgen v5 is current incompatible.

APIgen v4.1.0 can be installed globally using composer.

```bash
$ composer global require apigen/apigen:4.1.0
$ apigen --version
ApiGen version 4.1.0
```

###### Sphinx

Sphinx can be installed using Homebrew with the [sphinx-doc](https://www.macports.org/ports.php?by=library&substr=py36-sphinx) package.

```bash
$ brew install sphinx-doc
```

#### Building the Documentation

Install the node packages required to build the documentation.

```bash
$ npm install
```

Generate the documentation.

```bash
$ grunt update-docs
```

The dependencies will be installed and the documentation files will be built and compiled into the `.dev/docs/build/html/` directory.


#### Deploying the Documentation

The documentation can be deployed using:

```bash
$ grunt deploy-docs
```

The `deploy-docs` command will first run `update-docs` and then deploy the documentation files to the Primer `gh-pages` branch.

Once deployed your changes should be visible at [https://godaddy.github.io/wp-primer-theme/index.html](https://godaddy.github.io/wp-primer-theme/index.html)
