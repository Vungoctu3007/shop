<?php

class AuthMiddleware extends Middlewares {
    public function handle(){
        if(Session::data('user') != null) {
            $response = new Response();
            $response->redirect('trang-chu');
        } 
    }
}