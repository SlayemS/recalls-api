<?php declare(strict_types=1);
use Slim\Factory\AppFactory;
use Vanier\Api\Middleware\JWTAuthMiddleware;

define('APP_BASE_DIR',  __DIR__);
// TODO: This file must be added to your .gitignore file. 
define('APP_LOG_DIR', APP_BASE_DIR."/logs/");
define('APP_ENV_FILE', 'config.env');
define('APP_JWT_TOKEN_KEY', 'APP_JWT_TOKEN');

require __DIR__ . '/vendor/autoload.php';
use Vanier\Api\Middleware\ContentNegotiationMiddleware;

 // Include the file that contains the application's global configuration settings,
 // database credentials, etc.
require_once __DIR__ .'/app/Config/app_config.php';

//--Step 1) Instantiate a Slim app.
$app = AppFactory::create();
//-- Add the routing and body parsing middleware.
$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->addMiddleware(new ContentNegotiationMiddleware());
$app->addMiddleware(new JWTAuthMiddleware());
// NOTE: the error handling middleware MUST be added last.
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);

// TODO: change the name of the subdirectory here.
// You also need to change it in .htaccess
$app->setBasePath("/recalls-api");

// Here we include the file that contains the application routes. 
// NOTE: your routes must be managed in the api_routes.php file.
require_once __DIR__ . '/app/Routes/app_routes.php';

// Run the app.
$app->run();
