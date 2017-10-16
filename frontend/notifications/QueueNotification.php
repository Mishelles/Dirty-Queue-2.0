<?php
namespace frontend\notifications;

use Yii;
use webzop\notifications\Notification;

class QueueNotification extends Notification
{
    const KEY_QUEUE_GENERATED = 'queue_generated';

    public $queue;

    public function getTitle(){
        switch($this->key){
            case self::KEY_QUEUE_GENERATED:
                return Yii::t('app', 'Queue {queue} generated', ['queue' => $this->data->queue]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute(){
        return ['/rand/' . $this->data->queue];
    }
}
