<?php

namespace Core;

use Session\Message;
use Session\User as UserSession;
use Service\Game\Resource;
use Model\Message as MessageModule;

class Controller
{
    protected $data = [];
    protected $message;

    public function __construct()
    {
        $this->message = new Message();
        $this->userSession = new UserSession();
        $this->setErrorMessageForTemplate();
        $this->setSuccessMessageForTemplate();
        $this->initResourses();
        $this->newMesseges();

    }

    public function render($template, $data)
    {
        include_once PROJECT_ROOT . '/app/template/page/header.php';
        include_once PROJECT_ROOT . '/app/template/' . $template . '.php';
        include_once PROJECT_ROOT . '/app/template/page/footer.php';
        $this->message->unsetErorrMeesage();
        $this->message->unsetSuccessMeesage();

    }

    public function setErrorMessageForTemplate()
    {
        $this->data['error'] = $this->message->getErrorMessage();
    }

    public function setSuccessMessageForTemplate()
    {
        $this->data['success'] = $this->message->getSuccessMessage();
    }

    public function isLogedIn()
    {
        return $this->userSession->isLoged();
    }

    public function initResourses()
    {
        if ($this->isLogedIn()) {
            $resources = new Resource();
            $this->data['resources'] = $resources->getUserResources();
        } else {
            $this->data['resources'] = false;
        }
    }

    public function newMesseges()
    {
        if($this->isLogedIn())
        {
            $newMessagesCount = MessageModule::getNewMessages($this->userSession->getAuthUserId());
            $this->data['new_messages'] = $newMessagesCount[0]['count'];
        }
    }

}