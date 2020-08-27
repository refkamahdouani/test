<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\User\Service\UserUpdate;

final class DeleteAction
{
    public function __construct(UserUpdate $userUpdate) {

        $this ->userUpdate = $userUpdate;


    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        array $arg= []
    ): ResponseInterface {
         
        $values = [
           'id' => 1
         ];
        $user = $this->userUpdate->delete($values);
     
        $result = [
           
            'success' => true,
            'id' => $user

           
        ];

        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }



    }