<?php

namespace App\models;

use Core\Model;

#[\AllowDynamicProperties]

class User extends Model
{
    public function insert()
    {
        $db = self::connection();
        $sql = "insert into users (email, password) values (:email, :password);";

        $stm = $db->prepare($sql);

        $stm->bindParam(":email", $this->email);
        $stm->bindParam(":password", $this->password);

        $stm->execute();
    }

    public static function findByEmail($email)
    {
        $db = self::connection();
        $sql = "select * from users where email = :email";

        $stm = $db->prepare($sql);

        $stm->bindParam(":email", $email);

        $stm->execute();

        $stm->setFetchMode(\PDO::FETCH_CLASS, self::class);

        return $stm->fetch();
    }

    public function update($jwt)
    {
        $db = self::connection();
        $sql = "update users set token = :token where id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $jwt);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();
    }

    public static function findByToken($token)
    {
        $db = self::connection();
        $sql = "select * from users where token = :token";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);

        return $stmt->fetch();
    }

}