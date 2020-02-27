<?php

$template = <<<TMPL
name: qa
on: [push]
jobs:
{jobs}
TMPL;

$job = <<<JOB
  {template-name}:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v2

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '{php-version}'

      - name: Validate composer.json and composer.lock
        run: composer validate

      - name: Install composer helper
        run: composer global require hirak/prestissimo

      - name: Install dependencies
        run: composer install --prefer-dist --no-progress --no-suggest

      - name: Run PHPUnit
        run: vendor/bin/phpunit -c tests/build.xml

JOB;

$phpVersions = array (
    '5.3',
    '5.4',
    '5.5',
    '5.6',
    '7.0',
    '7.1',
    '7.2',
    '7.3',
    '7.4',
);

$actions = array ();

echo "GH WORKFLOW GENERATOR\n\n";

echo "-> BUILDING JOBS\n";
foreach ($phpVersions as $version) {
    echo "- PHP ${version}\n";
    $actions[] = str_replace(['{template-name}', '{php-version}'], [sprintf('PHP%s', str_replace('.', '_', $version)), $version], $job);
}
echo "\n";

$file = '/../.github/workflows/php.yml';
echo "-> WRITING WORKFLOW\n";
echo "- $file\n";
file_put_contents(__DIR__ . $file, str_replace('{jobs}', implode("\n", $actions), $template));
echo "\n";
