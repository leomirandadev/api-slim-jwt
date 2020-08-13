<?php
namespace Controllers;

use Jwt\JwtProcess;
use Models\User;
use Utils\Controller;

class UserController extends Controller
{

    /**
     * login
     *
     * @param  string $email
     * @param  string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        $userModel = new User;
        $results = $userModel->read(["email" => $email, "password_hash" => md5($password)], ['created_at', 'updated_at']);

        if (count($results) > 0) {

            $this->output["token"] = JwtProcess::encode($results[0]);
            $this->message = "Login with success";
            return true;
        }

        $this->message = "User not found";
        return false;

    }

    /**
     * new
     *
     * @param  array $infos
     * @return bool
     */
    public function create(array $infos): bool
    {
        $userModel = new User;
        $userModel->setCamps([
            "name" => $infos["name"],
            "email" => $infos["email"],
            "password_hash" => md5($infos["password"]),
        ]);

        $userID = $userModel->create();
        if ($userID > 0) {
            $this->output["id"] = $userID;
            $this->message = "User created";
            return true;
        }

        $this->message = "User not created";
        return false;
    }

    /**
     * getByID
     *
     * @param  int $ID
     * @return bool
     */
    public function getByID(int $ID): bool
    {
        $userModel = new User;
        $results = $userModel->read(["id" => $ID]);

        if (count($results) > 0) {
            $this->output = $results;
            $this->message = "User Found";
            return true;
        }

        $this->message = "User not found";
        return false;
    }

    /**
     * getAll
     *
     * @return bool
     */
    public function getAll(): bool
    {
        $userModel = new User;
        $results = $userModel->read();

        if (count($results) > 0) {
            $this->output = $results;
            $this->message = "User Found";
            return true;
        }

        $this->message = "User not found";
        return false;
    }
}
