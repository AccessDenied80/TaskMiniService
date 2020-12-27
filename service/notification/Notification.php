<?php
declare(strict_types=1);

namespace app\service\notification;

use app\service\notification\entity\Message;
use Yii;

/**
 * Class Notification
 * @package app\service\notification
 */
class Notification
{

    /**
     * @param Message $message
     * @return bool
     */
    public function send(Message $message): bool
    {
        try {
            $emailSender = new EmailService($_ENV['COMPANY_EMAIL']);
            $sender = new Sender($emailSender);

            if (!$sender->send($message)) {
                Yii::error('EmailService not send message. Alert.');
            }
        } catch (\Throwable $e) {
            Yii::error('EmailService exception: ' . $e->getMessage());
        }
        //$params = ['phone' => '+380', 'service' => ......];
        //$sender->setService(new SmsService($params));
        //$result = $sender->send($message);
        return true;
    }
}