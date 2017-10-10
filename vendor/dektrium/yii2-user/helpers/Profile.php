<?php
namespace dektrium\user\helpers;

use Yii;
use yii\db\Query;
class Profile
{
    public static function getWorkList(){
        $rows = (new \yii\db\Query())
        ->select(['id', 'subject', 'name', 'number'])
        ->from('work_list')
        ->where(['=', 'status', '1'])
        ->all();
        return $rows;
    }
    public static function getUserWorks($id_user){
        $rows = (new \yii\db\Query())
        ->select(['id_work', 'status'])
        ->from('users_work_status')
        ->where(['=', 'id_user', $id_user])
        ->all();
        return $rows;
    }
}
