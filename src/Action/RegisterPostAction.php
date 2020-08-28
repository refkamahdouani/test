<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\User\Service\UserUpdate;

final class RegisterPostAction
{
    public function __construct(UserUpdate $userUpdate){

        $this ->userUpdate = $userUpdate;

    }

   

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
        

    ): ResponseInterface {


        $body = (array)$request->getParsedBody();
        $headers = $request->getHeaders();


        $firstname = $body['firstname'];
        $lastname = $body['lastname'];
        $email = $body['email'];
        $password = $body['password'];

        $values = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' =>  $email,
            'password' =>  $password,
            'reg_date' => date('Y-m-d H:i:s')

         ];
        $user = $this->userUpdate->newinsert($values);
if ($user) {
    $result = [
        'success' => 1,
        'id' => $user
    ];
}else {
    $result = [
        'success' => 0
    ];
}


        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

            
    }
}