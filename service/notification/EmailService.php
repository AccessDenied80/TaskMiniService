<?php
declare(strict_types=1);

namespace app\service\notification;

use app\service\notification\entity\Message;

/**
 * Class EmailService
 * @package app\service\notification
 */
class EmailService implements SenderInterface
{
    /**
     * @var string
     */
    protected $toEmail;

    /**
     * EmailService constructor.
     * @param string $toEmail
     */
    public function __construct(string $toEmail)
    {
        $this->toEmail = $toEmail;
    }

    /**
     * @param Message $message
     * @return bool
     * @throws \Exception
     */
    public function send(Message $message): bool
    {
        if (filter_var($this->toEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception('Company Email address not valid');
        }

        return \Yii::$app->mailer->compose('notification/task.twig', ['text' => $message->text])
            ->setFrom([$_ENV['FROM_EMAIL'] => $_ENV['FROM_SITE_NAME']])
            ->setTo($this->toEmail)
            ->setSubject($message->title)
            ->send();
    }
}