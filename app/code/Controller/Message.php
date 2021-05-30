<?php

namespace Controller;

use Core\Controller;
use Core\Request;
use Helper\FormBuilder;
use Helper\Url;
use Model\Message as MessageModule;
use Session\User;
use Model\User as UserModel;

class Message extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->isLogedIn()) {
            Url::redirect(Url::make('/user/login'));
        }
    }

    public function index()
    {
        $userSession = new User();
        $allRecivedMessages = MessageModule::getAllrecevMessages(
            $userSession->getAuthUserId()
        );
        $recivedMessages = $this->getAllMessages($allRecivedMessages);

        $allSendMessages = MessageModule::getAllsendMessages(
            $userSession->getAuthUserId()
        );
        $sendedMessages = $this->getAllMessages($allSendMessages);

        $this->data['recived_messages'] = $recivedMessages;
        $this->data['sended_messages'] = $sendedMessages;
        $this->render('contact/message', $this->data);
    }

    public function getAllMessages($messages)
    {
        $user = new UserModel();
        $data = [];
        foreach ($messages as $key => $message) {
            if ($message['receiver_id']) {
                $data[$key]['sender_email'] = $user
                    ->load($message['receiver_id'])
                    ->getEmail();
            }
            $data[$key]['id'] = $message['id'];
            $data[$key]['subject'] = $message['subject'];
            $data[$key]['status'] = $message['status'];
            $data[$key]['create_at'] = $message['create_at'];
        }
        return $data;
    }

    public function createMessage($id)
    {
        $form = new FormBuilder('post', Url::make('/message/send/'));
        $form->input('recever_id', 'hidden', '' . $id . '');
        $form->input('replay_id', 'hidden', '' . $_GET['replayID'] . '');
        $form->input('subject', 'text', '', 'Subject');
        $form->texarea('message');
        $form->input('send_message', 'submit', 'Send message');
        $this->data['form'] = $form->get();
        $this->render('contact/createMessage', $this->data);
    }

    public function send()
    {
        $message = new MessageModule();
        $request = new Request();

        $receverId = $request->getPost('recever_id');
        $subject = $request->getPost('subject');
        $messageText = $request->getPost('message');
        $replayID = $request->getPost('replay_id');

        $message->setSubject($subject);
        $message->setMessage($messageText);
        $message->setStatus(1);
        if ($replayID) {
            $message->setReplyId($replayID);
        } else {
            $message->setReplyId('null');
        }

        $message->setSenderId($this->userSession->getAuthUserId());
        $message->setReceiverId($receverId);
        $message->save();

        $this->message->setSuccessMessage('Account created');

        Url::redirect(Url::make('/message'));
    }
    public function read($id)
    {
        $message = new MessageModule();
        $getMessage = $message->load($id);
        $allMessages = [];
        if (!empty($getMessage)) {
            if (
                $this->userSession->getAuthUserId() ===
                $getMessage->getReceiverId() ||
                $this->userSession->getAuthUserId() ===
                $getMessage->getSenderId()
            ) {
                $getMessage->setStatus('0');
                $getMessage->save();
                array_push($allMessages, $getMessage);
                $replayID = $getMessage->getReplyId();
                while ($replayID) {
                    $getReplayMessages = new MessageModule();
                    $getReplayMessage = $getReplayMessages->load($replayID);
                    array_unshift($allMessages, $getReplayMessage);
                    $replayID = $getReplayMessages->getReplyId();
                }

                $this->data['messages'] = $allMessages;

                $this->render('contact/readMessage', $this->data);
            }
        } else {
            Url::redirect(Url::make('/message'));
        }
    }
}