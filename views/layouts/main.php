<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$route_statusCollapse = Url::to(['site/status-collapse']);
$js = <<<JS
 $('.sidebar-toggle').click(function() {
                if($('body').delay(300).hasClass('sidebar-collapse')) {
                    jQuery.get('$route_statusCollapse',{status: 'open'})
                    $.cookie("sidebar","open");

                }
                else {
                    jQuery.get('$route_statusCollapse',{status: 'close'})
                    $.cookie("sidebar","close");
                }
            });
JS;

$this->registerJs($js);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body class="skin-green-light sidebar-mini hold-transition <?=(Yii::$app->session->get('menu_collapse')=='close') ? 'sidebar-collapse' : '' ?> ">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <header class="main-header">

            <?= Html::a('<span class="logo-mini">ПУ</span><span class="logo-lg">Панель управления</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Min</span>
                </a>
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li><?=Html::a('Создать заявку', ['order/create'])?></li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="/images/pcexpert160.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?=Yii::$app->user->identity->username?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="/images/pcexpert160.jpg" class="img-circle" alt="User Image">

                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a('Выход',['/site/logout'],['data-method' => 'post', 'class' => 'btn btn-default btn-flat','id'=>'button_logout']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <?= dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                        'items' => [
                            ['label' => 'Заявки', 'icon' => 'tasks', 'url' => ['/order/index']],
                            ['label' => 'Архив', 'icon' => 'archive', 'url' => ['/order/archive']],
                            ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/client/index']],
                            ['label' => 'Техника', 'icon' => 'laptop', 'url' => ['/equipment/index']],
                            ['label' => 'Справочники', 'icon' => 'folder-o', 'url' => '#', 'items' => [
                                ['label' => 'Виды техники', 'icon' => 'file-text-o', 'url' => ['/kind/index']],
                                ['label' => 'Производители', 'icon' => 'file-text-o', 'url' => ['/brand/index']],
                                ['label' => 'Модели', 'icon' => 'file-text-o', 'url' => ['/sample/index']],
                                ['label' => 'Бибилиотеки', 'icon' => 'file-text-o', 'url' => ['/library/index']],
                            ]],
                            ['label' => 'Admin'],
                            ['label' => 'Стоимость услуг', 'icon' => 'money', 'url' => '#', 'items' => [
                                ['label' => 'Категории', 'icon' => 'book', 'url' => ['/cat-service/index']],
                                ['label' => 'Услуги', 'icon' => 'folder', 'url' => ['/service/index']],
                            ]],
                            ['label' => 'Шаблоны', 'icon' => 'folder-o', 'url' => '#', 'items' => \app\models\Template::menuList()],
                            ['label' => 'Пользователи', 'icon' => 'user-secret', 'url' => ['/user/index']],
                        ]
                    ]
                )?>
            </section>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section  class="content-header">
                <h1>
                    <?=$this->title?>
                </h1>
                <?= Alert::widget() ?>
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Главная',
                        'url' => ['site/index'],
                    ],
                    'tag' => 'ol',
                    'options' => ['class' => 'breadcrumb'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?= $content ?>
            </section>

        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b>0.0.1 beta
            </div>
            <div class="text-center"><strong>Copyright &copy; <?=date('Y')?> PC Expert </strong> All rights reserved.</div>
        </footer>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>