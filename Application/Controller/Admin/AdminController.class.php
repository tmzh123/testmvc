<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminController extends BaseController{
    
    public function adminAction(){
        require __VIEW__.'admin.html';
    }
    
    public function topAction(){
        require __VIEW__.'top.html';
    }
    
    public function menuAction(){
        require __VIEW__.'menu.html';
    }
    
    public function mainAction(){
        require __VIEW__.'main.html';
    }
    
    public function dragAction(){
        require __VIEW__.'drag.html';
    }
    
}