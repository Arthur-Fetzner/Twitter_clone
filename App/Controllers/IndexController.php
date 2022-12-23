<?php

namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

//importar models

class IndexController extends Action{

    public function index(){
        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('index');
    }

    public function inscreverse(){
        $this->view->usuario = array(
            'nome' => '',
            'email' => '',
            'senha' => ''
        );

        $this->view->erroCadastro = false; 
        $this->render('inscreverse');
    }

    public function registrar(){
        if(isset($_POST['nome']) || isset($_POST['email']) || isset($_POST['senha'])){
            $usuario = Container::getModel('Usuario');

            $usuario_dados = array(
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha']
            );

            $usuario->__set('nome', $usuario_dados['nome']);
            $usuario->__set('email', $usuario_dados['email']);
            $usuario->__set('senha', md5($usuario_dados['senha']));

            if($usuario->validarCadastro()){
                if(count($usuario->getUsuarioPorEmail()) == 0){
                    $usuario->salvar();
                    $this->render('cadastro');
                }else{
                    $this->view->usuario = $usuario_dados;
                    $this->view->erroCadastro = 'email'; 
                    $this->render('inscreverse');    
                }
            }else{
                $this->view->usuario = $usuario_dados;
                $this->view->erroCadastro = 'campos'; 
                $this->render('inscreverse');
            }
        }else{
            $this->view->usuario = array(
                'nome' => '',
                'email' => '',
                'senha' => ''
            );    
            $this->view->erroCadastro = false; 
            $this->render('inscreverse');
        }
    }
}

?>