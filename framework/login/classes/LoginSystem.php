<?php

namespace WebWork\Features;

class LoginSystem {
    public static function login($email, $password, $message = 'Invalid email or password') {
        $user = DB::query("SELECT * FROM `users` WHERE `email` = '$email'");

        if (count($user) > 0 && password_verify($password, $user['password'])) {
            $_SESSION['WEBWORK_LOGGED'] = true;

            $_SESSION['WEBWORK_USER'] = new User($user);

            redirect('/');

            return true;
        }

        $_SESSION['WEBWORK_LOGGED'] = false;
        $_SESSION['WEBWORK_AUTH_FAIL'] = $message;

        redirect('/login');

        return false;
    }

    public static function logout() {
        session_unset();
        session_destroy();

        redirect('/login');
    }

    public static function isLogged() {
        if (isset($_SESSION['WEBWORK_LOGGED']) && $_SESSION['WEBWORK_LOGGED'] == true) {
            return true;
        }

        return false;
    }

    public static function user() {
        if (isset($_SESSION['WEBWORK_USER'])) {
            return $_SESSION['WEBWORK_USER'];
        }

        return null;
    }
}
