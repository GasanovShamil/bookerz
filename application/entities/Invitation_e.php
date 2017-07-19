<?php
class Invitation_e
{
    private $id;
    private $email;
    private $url;
    private $chatroom_id;

    public function __construct($id, $email, $url, $chatroom_id)
    {
        $this->id = $id;
        $this->email = $email;
        $this->url = $url;
        $this->chatroom_id = $chatroom_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getChatroom_id()
    {
        return $this->chatroom_id;
    }

    public function setChatroom_id($chatroom_id)
    {
        $this->chatroom_id = $chatroom_id;
    }
}
