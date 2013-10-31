<?php

namespace Fetcher\Configurator;

use \Fetcher\SiteInterface,
    \Fetcher\Task\TaskStack;

class DrushPrompts implements ConfiguratorInterface {

  static public function configure(SiteInterface $site) {
    // Note, this conifgurator is only intended for use with drush.
    $site['name'] = $site->share(function($c) {
      return \drush_prompt(\dt('Please specify a site name'));
    });
    // Get the environment for this operation.
    $site['environment.remote'] = $site->share(function($c) {
      if (isset($c['environments'])) {
        $environments = $c['environments']; 
        // If there is only 1 environment, use it.
        if (count($environments) == 1) {
          return $environments[0];
        }
        else if (count($environments) > 1) {
          return drush_prompt(dt('Please select an environment (@envs).', $args), array_pop(array_keys($environments)));
        }
        else {
          throw new \Fetcher\Exception\FetcherException('A valid environment could not be loaded');
        }
      }
    });
    // TODO: This should move or we should retitle this class drush - this isn't a prompt.
    $site['log function'] = 'drush_log';
  }
}
 
