<?php
declare(strict_types=1);

namespace app\service\notification;

use app\service\notification\entity\Message;

/**
 * Class Sender
 * @package app\service\notification
 */
class Sender
{

    /**
     * @var
     */
    protected $service;

    /**
     * Sender constructor.
     * @param $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * @param SenderInterface $service
     */
    public function setService(SenderInterface $service): void
    {
        $this->service = $service;
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function send(Message $message): bool
    {
        $this->service->send($message);
    }
}