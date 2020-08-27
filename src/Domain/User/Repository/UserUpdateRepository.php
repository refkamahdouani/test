<?php

namespace App\Domain\User\Repository;
use App\Repository\QueryFactory;
use Cake\Database\StatementInterface;

final class UserUpdateRepository {

    private $queryFactory; 

    public function __construct(QueryFactory $queryFactory) {
$this ->queryFactory = $queryFactory;


    }

    public function getusersDB():array{

        $query = $this->queryFactory->newSelect('users')->select('*');
        $rows = $query->execute()->fetchAll('assoc');

            return $rows;

    }

    public function getuserDB($id):array{

        $query = $this->queryFactory->newSelect('users')

        ->select('*')
        ->andWhere(['id' => $id]);
        $row = $query->execute()->fetchAll('assoc');

         return $row; 
    }

    public function newinsert($values){

        $newId = $this->queryFactory->newinsert('users', $values) ->execute()->lastInsertId();
      return $newId;


    }

    public function update($val){
        $values = $val["values"];
        $id = $val["id"];

$res = $this->queryFactory->newUpdate('users')->set($values)->andWhere(['id' => $id])->execute();
return $res;

    }

    public function delete($val){

        //$values = $val["values"];
        $id = $val["id"];

        $this->queryFactory->newDelete('users')
        ->andWhere(['id' =>$id])
        ->execute();


    }
}
