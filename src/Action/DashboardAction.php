<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use slim\views\twig;

final class DashboardAction
{
    public function __construct (twig $twig){
        $this-> twig=$twig;
    }

   

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        array $args = []
        

    ): ResponseInterface {

       $name =$args['name'];
       $data =['name'=> $name];

       $this ->twig->render($response, 'dashboard/dashboard.twig', $data );

       
        
        return $response;
            
    }
}