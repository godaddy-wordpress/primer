## Primer Theme Documentation

https://godaddy.github.io/wp-primer-theme/index.html

### How To

#### Requiremets

Before you can compile the documentation there are a few dependencies that need to be installed.

First, ensure your system has Python installed. You can check if Python is installed by running the following command:

```bash
$ python --version
```

If Python is installed you should see a version printed on screen:

```bash
Python 2.7.13
```

If Python is not installed you can install it via Homebrew using the following:

```bash
$ brew update && brew install python
```

Installing Python via Homebrew will also install pip.

If you installed Python another way you can install pip by doing the following:

```bash
$ sudo easy_install pip
```

Finally, you need to install the [Sphinx](http://www.sphinx-doc.org/) dependencies. You can do this by running the following command from the theme root.

```bash
$ sudo pip install -r .dev/docs/requirements.txt
```

After all of the dependencies are installed you will want to run `npm install` to install the node dependencies. Finally you can run `grunt docs` to compile the documentation into the `.dev/docs/en/documentation/` directory.undefined

#### Building the Documentation

The documentation for Primer theme is auto-generated using [ApiGen](http://www.apigen.org/) and [Sphinx](http://www.sphinx-doc.org/) and get re-built each time a new version of Primer is released.

Building the documentation is easy using the bundled Grunt tasks.

From the **theme root** the following command is used to generate documentation.

```bash
$ grunt docs
```

The documentation will be built and compiled into the `/documentation/build/html/en` directory. Feel free to preview the documentation before pushing changes live to the site.

#### Deploying the Documentation

When you are happy with the changes, the documentation can be deployed using:

```bash
$ grunt docs-deploy
```

Once the task is complete your changes should immediately be visible at https://godaddy.github.io/wp-primer-theme/index.html
