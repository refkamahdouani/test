<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\User\Service\UserUpdate;

final class UsersAction
{
    public function __construct(UserUpdate $userUpdate){

        $this->userUpdate = $userUpdate;

    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        
$users = $this->userUpdate->getUsers();
        $result = [
            'success' => true,
            'users' => $users
        ];

        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type','application/json')
            ->withStatus(200);
    }
}