<?php
declare(strict_types=1);

namespace app\service\notification;

use app\service\notification\entity\Message;

/**
 * Interface SenderInterface
 * @package app\service\notification
 */
interface SenderInterface
{
    /**
     * @param Message $message
     * @return bool
     */
    public function send(Message $message): bool;
}