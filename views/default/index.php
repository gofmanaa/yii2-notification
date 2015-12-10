<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 12/9/15
 * Time: 4:41 PM
 */
/**
 * @var $notifications \yii\data\ArrayDataProvider
 */
use gofmanaa\notification\models\Notification;
?>

<!-- Modal -->
<div class="modal fade" id="all-notification" data-url="<?= \yii\helpers\Url::to(['notification/default/delete'])?>" tabindex="-1" role="dialog" aria-labelledby="notifiModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="notifiModalLabel">All Notifications</h4>
            </div>

                <div class="modal-body">
                    <?php if($notifications->models): ?>
                        <?php \yii\widgets\Pjax::begin(['id'=>'ajax_content_notification','enablePushState'=>false]); ?>


                            <?php foreach($notifications->models as $notification): ?>
                                <?php /** @var $model Notification */ ?>

                                <div class="<?= Notification::getTypeAlertCss($notification->type) ?>" role="alert" >
                                    <button type="button" class="close delete" data-dismiss="alert" aria-hidden="true" data-id="<?= $notification->id ?>">&times;</button>
                                    <i class="icon <?= Notification::getTypeCss($notification->type,false); ?>"></i><?= $notification->message ?>
                                </div>
                            <?php endforeach; ?>

                            <?= \yii\widgets\LinkPager::widget([
                                'pagination'=>$notifications->pagination,
                            ]); ?>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default delete-all" data-dismiss="modal">Clear All</button>
                        </div>

                        <?php \yii\widgets\Pjax::end(); ?>
                    <?php else: ?>
                            <p class="text-center">You don't have notification.</p>
                    <?php endif; ?>

                </div>

        </div>
    </div>
</div>
