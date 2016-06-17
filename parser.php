<?php
require 'vendor/autoload.php';

$factory  = \phpDocumentor\Reflection\DocBlockFactory::createInstance();

$routesFile = '/Users/foush/Sites/tumblr/config/routes/api.php';

if (preg_match_all('#(\/\*\*.+\*\/)\n(\$router->.+?\n)#is', file_get_contents($routesFile), $matches) < 1) {
    exit('Uh oh, nothing matched');
}
$docblocks = $matches[1];
$routes = $matches[2];
foreach ($docblocks as $index => $str) {
    $docblock = $factory->create($str);
    $route = new \DocJam\Route($docblock->getTags(), $routes[$index]);
    if (!$route->offsetExists('v2')) {
        continue;
    }
    // if no version tag, skip

    // parse the tags out of the docblock

    // get the url

}
