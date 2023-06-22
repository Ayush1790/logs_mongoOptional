<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        //redirect to view
    }

    public function loginAction()
    {
        $email  = $this->request->getPost('email');
        $pswd  = $this->request->getPost('pswd');
        date_default_timezone_set("Asia/Calcutta");
        $res = $this->mongo->findOne(['email' => $email, 'pswd' => $pswd]);
        if ($res) {
            $this->logger->info('email => ' . $email . ' , time =>' . date("Y-m-d H:i:s"));
            echo "Success";
            die;
        } else {
            $this->logger->error('email => ' . $email . ' ,pswd => ' . $pswd . ' time =>' . date("Y-m-d H:i:s"));
            echo "error";
            die;
        }
    }
}
