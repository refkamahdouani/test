<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\User\Service\UserUpdate;

final class UserAction
{
    public function __construct(UserUpdate $userUpdate){

        $this ->userUpdate = $userUpdate;

    }
    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        array $arg= []
    ): ResponseInterface {
         $id = $arg['id'];
         $taken = $arg['taken'];


         //processing here
         $values = [
            'firstname' => 'john',
            'lastname' => 'doe',
            'email' => 'john.doe@example.com',
            'reg_date' => date('Y-m-d H:i:s')

         ];
        $user = $this->userUpdate->newinsert($values);
       //  $user = $this ->userUpdate->getuser($id);
        $result = [
            'success' => true,
            'id' => $user,
           // 'taken' => $taken,
            //'user-data' => $user

           
        ];

        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}