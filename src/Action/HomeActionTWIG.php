<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
final class HomeActionTWIG

{


    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }


    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        

        $viewData = [
            'name' => 'World',
            'notifications' => [
                'message' => 'You are good!'
            ],
        ];
        
        $this->twig->render($response, 'home/home-index.twig', $viewData);

        return $response;
    }
}