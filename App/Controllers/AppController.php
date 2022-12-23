<?php

namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

//importar models

class AppController extends Action{

    public function timeline(){
        
        $this->validaAutenticacao();
        
        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);
        $tweets = $tweet->getAll();

        $this->view->tweets = $tweets;

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweets();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores = $usuario->getTotalSeguidores();

        $this->render('timeline');   
    }

    public function tweet(){

        $this->validaAutenticacao();
        
        if($_POST['tweet'] != ''){
            $tweet = Container::getModel('Tweet');
            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweet->salvar();
            header('location: /timeline');
        }else{
            header('location: /timeline');
        }
    }

    public function quemSeguir(){
        $this->validaAutenticacao();

        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';
        
        $usuarios = array();
        $usuario = Container::getModel('Usuario');

        if($pesquisarPor != ''){
            $usuario->__set('nome', $pesquisarPor);
            $usuario->__set('id', $_SESSION['id']);
            $usuarios = $usuario->getAll();
            $this->view->padrao = false;
        }else{
            $usuario->__set('id', $_SESSION['id']);
            $usuarios = $usuario->getMaisSeguidos();    
            $this->view->padrao = true;
        }

        $this->view->usuarios = $usuarios;

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweets();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores = $usuario->getTotalSeguidores();

        $this->render('quemSeguir');
    }

    public function acao(){
        $this->validaAutenticacao();

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
    
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        if($acao == 'seguir'){
            $usuario->seguirUsuario($id_usuario_seguindo);
        }else if($acao == 'deixar_de_seguir'){
            $usuario->deixarSeguirUsuario($id_usuario_seguindo);
        }

        header('Location: /quem_seguir');
    }

    public function excluirTweet(){
        $this->validaAutenticacao();

        $id_postagem = isset($_POST['id_postagem']) ? $_POST['id_postagem'] : '';
        $id_usuario_do_post = isset($_POST['id_usuario_do_post']) ? $_POST['id_usuario_do_post'] : ''; 

        echo"<pre>";
        print_r($_POST);    
        echo"</pre>";

        $tweet = Container::getModel('Tweet');
        $tweet->__set('id', $id_postagem);
        $tweet->__set('id_usuario', $id_usuario_do_post);
        $tweet->excluir();
        header('location: /timeline');
    }

    public function validaAutenticacao(){
        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
            header('location: /?login=erro');
        }
    }
}

?>