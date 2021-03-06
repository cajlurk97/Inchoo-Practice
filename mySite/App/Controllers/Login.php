<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 8/16/18
 * Time: 8:39 AM
 */

namespace App\Controllers;


use Core\Controller;
use Core\Model;
use Core\View;
use App\Models;

class Login extends Controller
{
    public function indexAction()
    {

        session_start();
        if (isset($_SESSION['username'])) {
            View::renderTemplate('Home/index.html', ["name" => $_SESSION['username']]);
        } else {
            View::renderTemplate('Login/loginForm.html');
        }

    }


    public function loginAction()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (Models\Login::userExist($username)) {
            if (password_verify($password, Models\Login::getUserPassword($username)) && Models\Login::getUserActivateStatus($username)) {
                echo "successful login";
                session_start();
                $_SESSION['username'] = $username;

                View::renderTemplate('Home/index.html', ["name" => $username]);
            } else {
                echo "wrong password or acc is not activated";
                View::renderTemplate('Login/loginForm.html');
            }
        } else {
            echo "invalid user name";
            echo "<br> <a href=\"../newUser\">CreatenewAcc!</href></a>";
            View::renderTemplate('Login/loginForm.html');
        }

    }

    public function logoutAction()
    {
        session_start();
        unset($_SESSION['username']);
        echo "You are successfuly loged out, enetr cred. to login";
        View::renderTemplate('Login/loginForm.html');
    }


}