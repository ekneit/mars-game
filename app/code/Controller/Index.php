<?php

namespace Controller;
use Core\Controller;

class Index extends Controller
{
    public function index()
    {

        $this->render('main/homepage',$this->data);
    }
}