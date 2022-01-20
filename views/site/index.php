<?php

/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;
use app\models\Analytics;

$this->title = 'Дашборды';
?>
<div class="row">

    <div class="col-md-6 col-xs-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Доходы за неделю</h3>
            </div>
            <div class="box-body">
                <?= ChartJs::widget([
                    'type' => 'line',
                    'options' => [
                        'height' => 200,
                        'width' => 400
                    ],
                    'data' => [
                        'labels' => ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"],
                        'datasets' => [
                            [
                                'label' => "Прошлая неделя",
                                'backgroundColor' => "rgba(179,181,198,0.2)",
                                'borderColor' => "rgba(179,181,198,1)",
                                'pointBackgroundColor' => "rgba(179,181,198,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                'data' => Analytics::profitLastWeek()
                            ],
                            [
                                'label' => "Текущая неделя",
                                'backgroundColor' => "rgba(255,99,132,0.2)",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => Analytics::profitCurrentWeek()
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>


    </div>
    <div class="col-md-6 col-xs-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Количество заявок за неделю</h3>
            </div>
            <div class="box-body">
                <?= ChartJs::widget([
                    'type' => 'line',
                    'options' => [
                        'height' => 200,
                        'width' => 400
                    ],
                    'data' => [
                        'labels' => ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"],
                        'datasets' => [
                            [
                                'label' => "Прошлая неделя",
                                'backgroundColor' => "rgba(179,181,198,0.2)",
                                'borderColor' => "rgba(179,181,198,1)",
                                'pointBackgroundColor' => "rgba(179,181,198,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                'data' => Analytics::qtyLastWeek()
                            ],
                            [
                                'label' => "Текущая неделя",
                                'backgroundColor' => "rgba(255,99,132,0.2)",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => Analytics::qtyCurrentWeek()
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
