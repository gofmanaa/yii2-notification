<?php
/**
 * Created by PhpStorm.
 * User: gofmana
 * Date: 12/3/15
 * Time: 6:25 PM
 */

namespace gofmanaa\notification\events;


use yii\base\Event;

class NotificationEvent extends Event
{
    public $type;

    public $message;

    public $recipient_id;

    public $object_id;
}