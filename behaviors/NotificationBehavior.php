<?php
/**
 * Created by PhpStorm.
 * User: gofmana
 * Date: 12/9/15
 * Time: 10:47 AM
 */

namespace gofmanaa\notification\behaviors;


use common\modules\notification\events\NotificationEvent;
use common\modules\notification\models\Notification;
use yii\base\Behavior;

class NotificationBehavior extends Behavior
{
    const EVENT_NEW_NOTIFICATION = 'new_notification';

    public function events()
    {
        return [
            self::EVENT_NEW_NOTIFICATION => 'create',
        ];
    }

    public function create(NotificationEvent $event){
        /** @var Notification $model */
        $model = Notification::findOne(['recipient_id' => $event->recipient_id,'object_id'=>$event->object_id, 'type' => $event->type, 'message' => $event->message]);
        if(!$model) {
            $model = new Notification();// $event->sender;
            $model->type = $event->type;
            $model->message = $event->message;
            $model->recipient_id = $event->recipient_id;
            $model->object_id = $event->object_id;
            return $model->save();
        }
        return true;
    }
}