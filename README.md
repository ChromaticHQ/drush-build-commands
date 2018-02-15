# drush-build-commands
Drush commands to aid in the build process.

[![Build Status](https://travis-ci.org/ChromaticHQ/drush-build-commands.svg?branch=master)](https://travis-ci.org/ChromaticHQ/drush-build-commands)

## Requirements
- Drush 9
- Drupal 8

## Installation
`composer require chromatichq/drush-build-commands`

## Commands
### drush build:full
Runs a number of commands that are needed once new code has been pulled into an
environment including `composer install`, database updates, imports
configuration, and clears caches.

Aliases: build
