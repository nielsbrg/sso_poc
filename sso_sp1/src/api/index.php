<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Lcobucci\JWT\Builder;
use \Lcobucci\JWT\Signer\Hmac\Sha256 as Sha256;

require '../../vendor/autoload.php';

$app = new \Slim\App;

define('SSO_PASSWORD', '142.ssoPass');
define('SECRET', 'secret:SSO_SP1');

$app->post('/users/validate', function (Request $req, Response $res) {
    $body = $req->getParsedBody();
    return $res;
});

$app->post('/auth', function (Request $request, Response $response, $next) {
    $data = $request->getParsedBody();
    if(!empty($data['sso_password']) && $data['sso_password'] == SSO_PASSWORD) {
        return $response->withJson(['auth' => true, 'jwt' => generateJWT() . '']);
    }
    $errResponse = $response->withStatus(403);
    return $errResponse->withJson(['error' => 'Access denied']);
});

function generateJWT() {
    return (new Builder())
        ->setIssuer('SSO_SP1_API')
        ->setIssuedAt(time())
        ->setExpiration(time() + 3600)
        ->sign(new Sha256(), SECRET)
        ->getToken();
}

$app->run();