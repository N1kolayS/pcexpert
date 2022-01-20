<?php

namespace app\models;

use yii\base\Model;

class Analytics extends Model
{



    /**
     * Сумма дохода по дням недели за текущую неделю, массив из 7 значений по дням
     * @return int[]
     */
    public static function profitCurrentWeek(): array
    {
        return self::profitByWeek(
            new \DateTime('Monday this week'),
            new \DateTime('Tuesday this week'),
            new \DateTime('Wednesday this week'),
            new \DateTime('Thursday this week'),
            new \DateTime('Friday this week'),
            new \DateTime('Saturday this week'),
            new \DateTime('Sunday this week')
        );
    }

    /**
     * Сумма дохода по дням недели за прошлую неделю, массив из 7 значений по дням
     * @return int[]
     */
    public static function profitLastWeek(): array
    {
        return self::profitByWeek(
            new \DateTime('Monday ago'),
            new \DateTime('Tuesday ago'),
            new \DateTime('Wednesday ago'),
            new \DateTime('Thursday ago'),
            new \DateTime('Friday ago'),
            new \DateTime('Saturday ago'),
            new \DateTime('Sunday ago')
        );
    }

    /**
     * @return array
     */
    public static function qtyCurrentWeek(): array
    {
        return self::qtyByWeek(
            new \DateTime('Monday this week'),
            new \DateTime('Tuesday this week'),
            new \DateTime('Wednesday this week'),
            new \DateTime('Thursday this week'),
            new \DateTime('Friday this week'),
            new \DateTime('Saturday this week'),
            new \DateTime('Sunday this week')
        );
    }

    /**
     * @return array
     */
    public static function qtyLastWeek(): array
    {
        return self::qtyByWeek(
            new \DateTime('Monday ago'),
            new \DateTime('Tuesday ago'),
            new \DateTime('Wednesday ago'),
            new \DateTime('Thursday ago'),
            new \DateTime('Friday ago'),
            new \DateTime('Saturday ago'),
            new \DateTime('Sunday ago')
        );
    }

    /**
     * Сумма дохода по дням недели, массив из 7 значений по дням недели
     * @param \DateTime $Monday
     * @param \DateTime $Tuesday
     * @param \DateTime $Wednesday
     * @param \DateTime $Thursday
     * @param \DateTime $Friday
     * @param \DateTime $Saturday
     * @param \DateTime $Sunday
     * @return int[]
     */
    private static function profitByWeek(
        \DateTime $Monday,
        \DateTime $Tuesday,
        \DateTime $Wednesday,
        \DateTime $Thursday,
        \DateTime $Friday,
        \DateTime $Saturday,
        \DateTime $Sunday
    ): array
    {
        return [
            Order::find()->where(['DATE(created_at)' => $Monday->format('Y-m-d')])->sum('cost'),
            Order::find()->where(['DATE(created_at)' => $Tuesday->format('Y-m-d')])->sum('cost'),
            Order::find()->where(['DATE(created_at)' => $Wednesday->format('Y-m-d')])->sum('cost'),
            Order::find()->where(['DATE(created_at)' => $Thursday->format('Y-m-d')])->sum('cost'),
            Order::find()->where(['DATE(created_at)' => $Friday->format('Y-m-d')])->sum('cost'),
            Order::find()->where(['DATE(created_at)' => $Saturday->format('Y-m-d')])->sum('cost'),
            Order::find()->where(['DATE(created_at)' => $Sunday->format('Y-m-d')])->sum('cost'),
        ];
    }

    /**
     * Количество заявок по дням недели, массив из 7 значений по дням недели
     * @param \DateTime $Monday
     * @param \DateTime $Tuesday
     * @param \DateTime $Wednesday
     * @param \DateTime $Thursday
     * @param \DateTime $Friday
     * @param \DateTime $Saturday
     * @param \DateTime $Sunday
     * @return array
     */
    private static function qtyByWeek(
        \DateTime $Monday,
        \DateTime $Tuesday,
        \DateTime $Wednesday,
        \DateTime $Thursday,
        \DateTime $Friday,
        \DateTime $Saturday,
        \DateTime $Sunday
    ): array
    {
        return [
            Order::find()->where(['DATE(created_at)' => $Monday->format('Y-m-d')])->count(),
            Order::find()->where(['DATE(created_at)' => $Tuesday->format('Y-m-d')])->count(),
            Order::find()->where(['DATE(created_at)' => $Wednesday->format('Y-m-d')])->count(),
            Order::find()->where(['DATE(created_at)' => $Thursday->format('Y-m-d')])->count(),
            Order::find()->where(['DATE(created_at)' => $Friday->format('Y-m-d')])->count(),
            Order::find()->where(['DATE(created_at)' => $Saturday->format('Y-m-d')])->count(),
            Order::find()->where(['DATE(created_at)' => $Sunday->format('Y-m-d')])->count(),
        ];
    }
}