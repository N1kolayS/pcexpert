<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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
    <body class="skin-blue sidebar-mini hold-transition ">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <header class="main-header">

            <?= Html::a('<span class="logo-mini">ПУ</span><span class="logo-lg">Панель управления</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Min</span>
                </a>
                <div class="navbar-custom-menu">
                    <div class="pull-right">

                        <?= Html::a('Выход',['/site/logout'],['data-method' => 'post', 'class' => 'btn btn-default btn-flat','id'=>'button_logout']) ?>

                    </div>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <!--
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <br>
                   </div>
                <div class="pull-left info">
                    <p><?= !(Yii::$app->user->isGuest) ? Yii::$app->user->identity->fio : ''?></p>
                </div>
            </div>
        </section>
        -->
            <section class="sidebar">

                <?= dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                        'items' => []
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
                <b>Version</b> 2.0
            </div>
            <div class="text-center"><strong>Copyright &copy; <?=date('Y')?>Genomed </strong> All rights reserved.</div>
        </footer>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>