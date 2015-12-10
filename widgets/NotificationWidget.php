<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 12/9/15
 * Time: 1:54 PM
 */

namespace gofmanaa\notification\widgets;

use gofmanaa\notification\assets\NotificationAsset;
use Yii;
use gofmanaa\notification\models\Notification;
use yii\bootstrap\Widget;
use yii\helpers\Url;
use yii\web\View;


class NotificationWidget extends Widget
{


    public function init()
    {
        parent::init();
        $this->registerJs();
        $this->registerAssets();

    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        NotificationAsset::register($view);

    }

    public function run()
    {
        $notifications = Notification::getNotifications(false);
        return $this->render('menu',['notifications'=>$notifications]);
    }

    public function registerJs(){
        $url =Yii::$app->request->getBaseUrl().DIRECTORY_SEPARATOR. Url::to('notification/default/index');
        $delete_url =Yii::$app->request->getBaseUrl().DIRECTORY_SEPARATOR. Url::to('notification/default/delete');
        $delete_all_url =Yii::$app->request->getBaseUrl().DIRECTORY_SEPARATOR. Url::to('notification/default/delete-all');
        $check_url =Yii::$app->request->getBaseUrl().DIRECTORY_SEPARATOR. Url::to('notification/default/check-new');
        $script =
        "$( window ).load(function() {
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'{$url}',
                success:function(res){
                    $('body').append(res);
                            $('#all-notification').on('click','.delete',function(e){
                                $.ajax({
                                    type:'POST',
                                    dataType:'json',
                                    url:'{$delete_url}',
                                    context:this,
                                    data:{id:$(this).data('id')},
                                    success:function(res){
                                        $(this).closest('div').fadeOut();
                                    },
                                    error: function (jqXHR, textStatus) {
                                        alert( 'Internal Error!' );
                                    }
                                });
                            });
                            $('#all-notification').on('click','.delete-all',function(e){
                                $.ajax({
                                    type:'POST',
                                    dataType:'json',
                                    url:'{$delete_all_url}',
                                    success:function(res){
                                        if(res){
                                            $('#ajax_content_notification').remove();
                                            $('.dropdown.notifications-menu').remove();
                                        }
                                    },
                                });
                            });
                },
                error: function (jqXHR, textStatus) {
                    alert( 'Internal Error!' );
                }
            });
        });


        ";
        $this->getView()->registerJs($script,View::POS_END);

    }
}