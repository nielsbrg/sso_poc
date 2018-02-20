<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Lcobucci\JWT\Builder as JWTBuilder;
use Lcobucci\JWT\Parser as JWTParser;
use \Lcobucci\JWT\Signer\Hmac\Sha256 as Sha256;
use \Lcobucci\JWT\ValidationData as ValidationData;

require '../../vendor/autoload.php';
require('../config/sp_config.php');
require('../database/DatabaseConnection.php');
require('UserValidationService.php');

$app = new \Slim\App;

define('SSO_PASSWORD', '142.ssoPass');
define('SECRET', 'secret:SSO_SP2');
define('ISSUER', 'SSO_SP2_API');

$app->post('/users/validate', function (Request $req, Response $res) {
    $authHeader = str_replace('Bearer ', '', $req->getHeader('Authorization'))[0];
    $token = (new JWTParser())->parse($authHeader);
    $validation = new ValidationData();
    $validation->setIssuer(ISSUER);
    if($token->validate($validation)) {
        $validationService = new UserValidationService();
        $body = $req->getParsedBody();
        $returnData = $validationService->validate(array('username' => $body['username'], 'password' => $body['password']));
        return $res->withJson($returnData);
    }
    else {
        return $res->withStatus(401)->withJson(['error' => 'supplied invalid access token']);
    }
});

$app->post('/auth', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    if(!empty($data['sso_password']) && $data['sso_password'] == SSO_PASSWORD) {
        return $response->withJson(['succeeded' => true, 'jwt' => generateJWT() . '']);
    }
    $errResponse = $response->withStatus(403);
    return $errResponse->withJson(['error' => 'Access denied']);
});

function generateJWT() {
    return (new JWTBuilder())
        ->setIssuer(ISSUER)
        ->setIssuedAt(time())
        ->setExpiration(time() + 60)
        ->sign(new Sha256(), SECRET)
        ->getToken();
}

$app->run();