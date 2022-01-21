<?php

/* @var $this yii\web\View */
/* @var $analytics Analytics */

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
                                'data' => $analytics->profitLastWeek()
                            ],
                            [
                                'label' => "Текущая неделя",
                                'backgroundColor' => "rgba(255,99,132,0.2)",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => $analytics->profitThisWeek()
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-xs-12">
                    <div class="description-block border-right">
                        <span class="description-percentage text-grey"><i class="fa fa-caret"></i> </span>
                        <h5 class="description-header"><?=Yii::$app->formatter->asCurrency($analytics->totalProfitLastWeek(), null,  [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]) ?></h5>
                        <span class="description-text">Всего за прошлую неделю</span>
                    </div>
                    <!-- /.description-block -->
                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="description-block ">
                        <?php if ($analytics->percentBetweenWeek()>0): ?>
                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?=round($analytics->percentBetweenWeek(),2 )?>%</span>
                        <?php else: ?>
                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?=round($analytics->percentBetweenWeek(), 2)?>%</span>
                        <?php endif; ?>
                        <h5 class="description-header"><?=Yii::$app->formatter->asCurrency($analytics->totalProfitThisWeek(),null,  [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]) ?></h5>
                        <span class="description-text">Всего за эту неделю</span>
                    </div>
                    <!-- /.description-block -->
                </div>

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
                                'data' => $analytics->qtyLastWeek()
                            ],
                            [
                                'label' => "Текущая неделя",
                                'backgroundColor' => "rgba(255,99,132,0.2)",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => $analytics->qtyThisWeek()
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
