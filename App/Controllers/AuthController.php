<?php

namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

//importar models

class AuthController extends Action{

    public function autenticar(){
        if(isset($_POST['email']) || isset($_POST['senha'])){
            $usuario = Container::getModel('Usuario');

            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', md5($_POST['senha']));

            $usuario->autenticar();

            if($usuario->__get('id') != '' && $usuario->__get('nome') != ''){
                session_start();

                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');

                header('location: /timeline');
            }else{
                header('location: /?login=erro');
            }
        }else{
            header('location: /?login=erro');
        }
    }

    public function sair(){
        session_start();
        session_destroy();
        header('location: /');
    }
}