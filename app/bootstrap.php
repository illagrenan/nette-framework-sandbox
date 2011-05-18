<?php
/**
 * This file is part of the Nella Framework.
 *
 * Copyright (c) 2006, 2011 Patrik Votoček (http://patrik.votocek.cz)
 *
 * This source file is subject to the GNU Lesser General Public License. For more information please see http://nella-project.org
 */


use Nette\Diagnostics\Debugger,
	Nette\Environment;

require_once LIBS_DIR . "/Nella/loader.php";

Debugger::enable();

Environment::loadConfig(__DIR__ . "/config.neon"/* , 'vrtak'*/);

// Setup application
$application = Environment::getApplication();
//$application->errorPresenter = 'Error';
$application->catchExceptions = (bool) Debugger::$productionMode;

require_once __DIR__ . "/routes.php";

$application->run();
