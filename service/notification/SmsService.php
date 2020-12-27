<?php
declare(strict_types=1);

namespace app\service\notification;

use app\service\notification\entity\Message;

/**
 * Class SmsService
 * @package app\service\notification
 */
class SmsService implements SenderInterface
{

    /**
     * SmsService constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function send(Message $message): bool
    {
        return true;
    }

}