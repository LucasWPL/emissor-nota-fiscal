<?php

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->addDefinitions(__DIR__ . '/dependencies/dependencies.php');
$builder->addDefinitions(__DIR__ . '/settings/settings.php');

return $builder->build();
