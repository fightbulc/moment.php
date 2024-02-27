# CONTRIBUTING

We use [GitHub Actions](https://github.com/features/actions) as a continuous integration system.

For details, take a look at the following workflow configuration files:

- [`workflows/integrate.yaml`](workflows/integrate.yaml)

## Tests

We use [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit) to drive the development.

Run

```sh
vendor/bin/phpunit --configuration=tests/phpunit.xml
```

to run all the tests.
