<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PostsAction
{
    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response

    ): ResponseInterface {
        $body = (array)$request->getParsedBody();
        $headers = $request->getHeaders();

        $h1 = $headers['h1'];
        $h2 = $headers['h2'];

        $b1 = $body['b1'];
        $b2 = $body['b2'];
       

        $result = [
            'success' => true,
            
            'h1' => $h1[0],
            'h2' => $h2[0],
            'b1' => $b1,
            'b2' => $b2
        ];

        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}