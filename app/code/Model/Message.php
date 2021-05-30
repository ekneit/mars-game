<?php
namespace Model;

use Model\ModelAbstract;
use Core\Db;

class Message extends ModelAbstract
{
    public const TABLE_NAME = 'message';
    public const SUBJECT_COLUMN = 'subject';
    public const MESSAGE_COLUMN = 'message';
    public const REPLAY_ID_COLUMN = 'reply_id';
    public const STATUS_COLUMN = 'status';
    public const SENDER_ID_COLUMN = 'sender_id';
    public const RECEIVER_ID_COLUM = 'receiver_id';

    private $subject;
    private $message;
    private $replyId;
    private $status;
    private $senderId;
    private $receiverId;

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getReplyId()
    {
        return $this->replyId;
    }

    /**
     * @param mixed $replyId
     */
    public function setReplyId($replyId): void
    {
        $this->replyId = $replyId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $senderId
     */
    public function setSenderId($senderId): void
    {
        $this->senderId = $senderId;
    }

    /**
     * @return mixed
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @param mixed $receiverId
     */
    public function setReceiverId($receiverId): void
    {
        $this->receiverId = $receiverId;
    }
    public static function getNewMessages($id)
    {
        $db = new DB();
        return $db
            ->select('COUNT(*) as count')
            ->from(self::TABLE_NAME)
            ->where(self::RECEIVER_ID_COLUM, $id)
            ->whereAnd(self::STATUS_COLUMN, '1')
            ->get();
    }
    public static function getAllrecevMessages($id)
    {
        $db = new DB();
        return $db
            ->select('id,subject,receiver_id,status,create_at')
            ->from(self::TABLE_NAME)
            ->where(self::RECEIVER_ID_COLUM, $id)
            ->get();
    }
    public static function getAllsendMessages($id)
    {
        $db = new DB();
        return $db
            ->select('id,subject,sender_id,status,create_at')
            ->from(self::TABLE_NAME)
            ->where(self::SENDER_ID_COLUMN, $id)
            ->get();
    }
    public function load($id)
    {
        $db = new Db();
        $messages = $db
            ->select()
            ->from(self::TABLE_NAME)
            ->where(self::ID_COLUMN, $id)
            ->getOne();
        if (!empty($messages)) {
            $this->id = $messages[self::ID_COLUMN];
            $this->subject = $messages[self::SUBJECT_COLUMN];
            $this->message = $messages[self::MESSAGE_COLUMN];
            $this->replyId = $messages[self::REPLAY_ID_COLUMN];
            $this->status = $messages[self::STATUS_COLUMN];
            $this->senderId = $messages[self::SENDER_ID_COLUMN];
            $this->receiverId = $messages[self::RECEIVER_ID_COLUM];

            return $this;
        }

        return null;
    }

    public function prepeareArray()
    {
        return [
            self::SUBJECT_COLUMN => $this->subject,
            self::MESSAGE_COLUMN => $this->message,
            self::REPLAY_ID_COLUMN => $this->replyId,
            self::STATUS_COLUMN => $this->status,
            self::SENDER_ID_COLUMN => $this->senderId,
            self::RECEIVER_ID_COLUM => $this->receiverId,
        ];
    }
}
