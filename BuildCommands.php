<?php

namespace Drush\Commands\drush_build_commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class BuildCommands extends DrushCommands
{

  /**
   * Runs database updates, imports configuration, and clears caches.
   *
   * @command build:full
   * @aliases build
   * @bootstrap full
   */
    public function deployment()
    {
        // Install the latest composer dependencies.
        chdir(DRUPAL_ROOT . '/..');
        shell_exec('composer install');

        // Clear caches so renamed services or similar cached items are updated
        // to reflect the latest code.
        $this->logger()->notice('Clearing caches.');
        drush_invoke_process('@self', 'cache-rebuild');

        // Update the database to support the latest configuration.
        $this->logger()->notice('Updating the database.');
        drush_invoke_process('@self', 'updatedb');

        drush_invoke_process('@self', 'cc', ['drush']);
        // Import the latest configuration. This includes the latest
        // configuration_split configuration. Importing this twice ensures that
        // the second operation enables and disables modules based upon upon the
        // potentially altered configuration split configuration.
        $this->logger()->notice('Importing configuration.');
        drush_invoke_process('@self', 'config-import');

        $this->logger()->notice('Importing configuration.');
        drush_invoke_process('@self', 'config-import');

        // Clear caches again after the latest configuration has been imported.
        $this->logger()->notice('Clearing caches.');
        drush_invoke_process('@self', 'cache-rebuild');

        $this->logger()->success('Build and import commands completed.');
    }
}
