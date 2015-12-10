<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 12/9/15
 * Time: 1:53 PM
 */
/**
 * @var $notifications \yii\data\ArrayDataProvider
 */
use gofmanaa\notification\models\Notification;
?>
<!-- Notifications: style can be found in dropdown.less -->

<li class="dropdown notifications-menu" data-url="<?= \yii\helpers\Url::to(['notification/default/touch'])?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning"><?= $notifications->totalCount; ?></span>
    </a>

        <ul class="dropdown-menu">

            <li class="header"><?= Yii::t('app','You have {0} new notifications.',$notifications->totalCount) ?> </li>
            <li>
                <!-- inner menu: contains the actual data -->
                <?php if($notifications->models): ?>
                <ul class="menu">
                    <?php foreach($notifications->models as $model): ?>
                        <?php /** @var $model Notification */ ?>
                        <li  class="notification <?= $model->isRead()?'':'not_read' ?>" data-id="<?= $model->id ?>">
                            <a href="#">
                                <i class="<?= Notification::getTypeCss($model->type); ?>"></i> <?= $model->message ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
            <li class="footer"><a href="#" data-toggle="modal" data-target="#all-notification" class="view-all">View all</a></li>
        </ul>

</li>

