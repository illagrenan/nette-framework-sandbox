<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;

// Load Nette Framework
require LIBS_DIR . '/autoload.php';


// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');
\Nette\Diagnostics\Debugger::$email = 'no-reply@***.cz';
// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
        ->addDirectory(APP_DIR)
        ->register();

\Nella\Console\Config\Extension::register($configurator);
\Nella\Doctrine\Config\Extension::register($configurator);
\Nella\Doctrine\Config\MigrationsExtension::register($configurator);
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace('JMS\Serializer\Annotation', LIBS_DIR . "/jms/serializer/src");
Kdyby\Replicator\Container::register();

if (CLIDatabaseRemoteSync::isCLI() && !CLIDatabaseRemoteSync::syncWithRemoteDatabase())
{
    $configurator->addConfig(__DIR__ . '/config/config.neon', "development");
    $configurator->setProductionMode(FALSE);
    $configurator->setDebugMode(TRUE);
} else
{
    $configurator->addConfig(__DIR__ . '/config/config.neon');
}

// Create Dependency Injection container from config.neon file
$container = $configurator->createContainer();

$platform = $container->doctrine->entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');
$platform->registerDoctrineTypeMapping('set', 'string');

// Setup router
$container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
$container->router[] = new Route('<presenter>/<action>[.json][/<id>]', 'Homepage:default');


// Configure and run the application!
$container->application->run();

