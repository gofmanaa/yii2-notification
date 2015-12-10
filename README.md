Notification
============
Notification module 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist gofmanaa/yii2-notification "*"
```

or add

```
"gofmanaa/yii2-notification": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \gofmanaa\notification\models\Notification::push('Event message',Notification::TYPE_DEFAULT); ?>
```
Put to header menu:
```php
\gofmanaa\notification\widgets\NotificationWidget::widget();
```

