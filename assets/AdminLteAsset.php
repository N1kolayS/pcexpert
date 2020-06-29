<?php



namespace app\assets;

use yii\web\AssetBundle;

/**
 * LTE asset
 *
 * @author https://github.com/dmstr/yii2-adminlte-asset
 * @since 2.0
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $js = [
        //  'datatables/dataTables.bootstrap.min.js',
        // more plugin Js here
    ];
    public $css = [
        //    'datatables/dataTables.bootstrap.css',
        // more plugin CSS here
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}