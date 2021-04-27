<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

// $kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel = new Kernel($_SERVER['APP_ENV'], False);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

// if (true || in_array($this->getEnvironment(), ['dev', 'test'], true)) {
//     $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
//     $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
//     $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();