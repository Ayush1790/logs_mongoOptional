<?php

use Phalcon\Mvc\Controller;
use Phalcon\Escaper;

class RegistrationController extends Controller
{
    public function indexAction()
    {
        $this->response->redirect("registration/register");
    }
    public function registerAction()
    {
        //redirect to view
    }
    public function processAction()
    {
        $escaper = new Escaper();
        $name  = $this->request->getPost('name');
        $email  = $this->request->getPost('email');
        $pswd  = $this->request->getPost('pswd');
        $data = [
            'name' => $escaper->escapeHtml($name ),
            'email' => $escaper->escapeHtml($email ),
            'pswd' => $escaper->escapeHtml($pswd )
        ];
        $this->mongo->insertOne($data);
        $this->response->redirect('login');
                 
    }
}
