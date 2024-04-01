<?php

namespace app\mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    protected $mailer;
    protected $error;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTo($email, $name)
    {
        $this->mailer->addAddress($email, $name);
    }

    public function formatEmail($info)
    {
        $this->mailer->Subject = $info['subject'];
        $this->mailer->Body = $info['body'];
        $this->mailer->AltBody = strip_tags($info['body']);
    }

    public function setSMTPConfig($host, $username, $password, $port, $fromEmail, $fromName, $replyEmail, $replyName, $debug = 0)
    {
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug   = $debug;
        $this->mailer->Host        = $host;
        $this->mailer->SMTPAuth    = true;
        $this->mailer->Username    = $username;
        $this->mailer->Password    = $password;
        $this->mailer->SMTPSecure  = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port        = $port;
        $this->mailer->setFrom($fromEmail, $fromName);
        $this->mailer->addReplyTo($replyEmail, $replyName);
        $this->mailer->CharSet = "UTF-8";
    }

    public function sendEmail()
    {
        try {
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            $this->error = $e;
            throw $e;
        }
    }

    public function getError()
    {
        return $this->error;
    }

    public function getMailer()
    {
        return $this->mailer;
    }
}
