## Acceptance Tests

##### Prerequisites

###### Setup your local environment

Have a Mac? We recommend Valet.

###### Install the Codeception PHAR globally

```
sudo curl -LsS http://codeception.com/codecept.phar -o /usr/local/bin/codecept
sudo chmod a+x /usr/local/bin/codecept
```

Then, check if it works:

```
$ codecept --version
```

**IMPORTANT:** Codeception requires PHP 5.4 or higher.

###### Point Codeception to your local URL

The `url` option in `tests/codeception/acceptance.suite.yml` will need to point to your the URL of your local development site. The default is `http://wp.dev`.

##### Run the tests

```
cd /path/to/wordpress/wp-content/themes/primer
codecept run acceptance
```
