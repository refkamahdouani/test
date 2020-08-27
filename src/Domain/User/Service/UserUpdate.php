<?php

namespace App\Domain\User\Service;
use App\Domain\User\Repository\UserUpdateRepository;

final class UserUpdate {

    public function __construct(UserUpdateRepository $userUpdateRepository) {
$this->userUpdateRepository = $userUpdateRepository;

    }

    public function getUsers():array{


//this methode are responsable for doing test befor passing test to repository 
//we call this methode after the test 

$users = $this ->userUpdateRepository->getusersDB();

return $users;
    }

    public function getUser($id):array{


        //this methode are responsable for doing test befor passing test to repository 
        //we call this methode after the test 
        
        $user = $this ->userUpdateRepository->getuserDB($id);
        
        return $user;
            }


     public function newinsert($values){

        $user = $this->userUpdateRepository->newinsert($values);
         return $user;

     }       

     public function update($val) {

        $user = $this->userUpdateRepository->update($val);
        return $user; 

     }
     public function delete($val) {

        $user = $this->userUpdateRepository->delete($val);
    
        return $user; 
     }


}