<?php

namespace gofmanaa\notification\models;


use gofmanaa\notification\behaviors\NotificationBehavior;
use gofmanaa\notification\events\NotificationEvent;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $type
 * @property string $message
 * @property string $recipient_id
 * @property string $object_id
 * @property integer $is_read
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Notification extends ActiveRecord
{


    /**
     * Default notification
     */
    const TYPE_DEFAULT = 0;
    /**
     * Success notification type
     */
    const TYPE_SUCCESS = 1;
    /**
     * Warning notification
     */
    const TYPE_WARNING = 3;
    /**
     * Error notification
     */
    const TYPE_ERROR   = 6;


    const DATETIME_FORMAT = "Y-m-d H:i:s";
    const DATE_FORMAT = "Y-m-d";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }


    public function behaviors() {
        return [
            'notification' =>[
                'class' => NotificationBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'message', 'created_at'], 'required'],
            [['type','recipient_id','object_id', 'is_read', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['message'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'message' => 'Message',
            'recipient_id' => 'Recipient Id',
            'object_id' => 'Object Id',
            'is_read' => 'Is Read',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function beforeValidate()
    {
        try {
            if ($this->isNewRecord && empty($this->created_at))
                $this->created_at = self::createDateTime();
            else if (!$this->isNewRecord)
                $this->updated_at = self::createDateTime();
        } catch (\Exception $e) {
            \Yii::warning($e->getMessage(),__METHOD__);
        }

        return parent::beforeValidate();
    }


    public static function createDateTime($utctime=null)
    {
        return date(self::DATETIME_FORMAT,$utctime === null ? time():$utctime);
    }


    public function isRead(){
        return (bool) $this->is_read;
    }

    public function getTypesArray(){
        return [
            self::TYPE_DEFAULT =>['class'=>'fa fa-info-circle', 'text-color'=>' text-aqua',  'title'=>'Info', 'alert-class'=>'alert alert-info alert-dismissible'],
            self::TYPE_WARNING =>['class'=>'fa fa-warning', 'text-color'=>' text-yellow',  'title'=>'Warning', 'alert-class'=>'alert alert-warning alert-dismissible'],
            self::TYPE_ERROR =>  ['class'=>'fa fa-warning',   'text-color'=>' text-red', 'title'=>'Error', 'alert-class'=>'alert alert-danger alert-dismissible'],
            self::TYPE_SUCCESS =>['class'=>'fa fa-check',   'text-color'=>' text-green',   'title'=>'Success',  'alert-class'=>'alert alert-success alert-dismissible'],
        ];
    }

    public static function  getTypeCss($type,$enable_color=true)
    {
        $types = self::getTypesArray();
        return isset($types[$type]) ? $types[$type]['class'].($enable_color?$types[$type]['text-color']:'') : $type;
    }

    public static function  getTypeAlertCss($type)
    {
        $types = self::getTypesArray();
        return isset($types[$type]) ? $types[$type]['alert-class'] : $type;
    }

    public static function  getTypeTitle($type)
    {
        $types = self::getTypesArray();
        return isset($types[$type]) ? $types[$type]['title'] : $type;
    }

    /**
     * @param boolean $is_read
     * @return ArrayDataProvider
     */
    public static function getNotifications($is_read = null){
        $query = self::find();
        if($is_read !== null){
            $query->andWhere(['is_read'=>$is_read]);
        }
        $models = $query->all();

        return new ArrayDataProvider(['allModels'=>$models]);
    }

    /**
     * @param integer $user_id
     * @param boolean $is_read
     * @return ArrayDataProvider
     *
     */
    public static function getNotificationsByUser($user_id, $is_read = null){
        $query = self::find()->where(['recipient_id'=>$user_id]);
        if($is_read !== null){
            $query->andWhere(['is_read'=>$is_read]);
        }
        $models = $query->all();
        return new ArrayDataProvider(['allModels'=>$query]);
    }


    /**
     * @param integer $user_id
     * @param boolean $is_read
     * @return int|string
     */
    public static function getNotificationsByUserCount($user_id, $is_read = null){
        $query =  self::find()->where(['recipient_id'=>$user_id]);
        if($is_read !== null){
            $query->andWhere(['is_read'=>$is_read]);
        }
        return $query->count();
    }

    /**
     * @param boolean $is_read
     * @return int|string
     */
    public static function getNotificationsCount($is_read = null){
        $query =  self::find();
        if($is_read !== null){
            $query->andWhere(['is_read'=>$is_read]);
        }
        return $query->count();
    }

    /**
     * @param integer $id
     * @return bool|int
     * @throws \Exception
     */
    public static function touch($id){
        $model = self::findOne($id);
        $model->is_read = 1;
        return $model->update();
    }

    public static function push( $message, $type = self::TYPE_DEFAULT, $recipient_id = null, $object_id = null)
    {
        $event = new NotificationEvent();
        $event->type = $type;
        $event->message = $message;
        $event->recipient_id = $recipient_id;
        $event->object_id = $object_id;
        $instance = new static;
        $instance->trigger(NotificationBehavior::EVENT_NEW_NOTIFICATION,$event);
    }


}
