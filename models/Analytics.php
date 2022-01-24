<?php

namespace app\models;

use yii\base\Model;

/**
 * Аналитика
 */
class Analytics extends Model
{

    private $_qtyLastWeek;
    private $_qtyThisWeek;

    private $_profitLastWeek;
    private $_profitThisWeek;

    /**
     * @return bool|int|string|null
     */
    public static function qtyComplete()
    {
        return Order::find()->where(['status' => Order::STATUS_COMPLETE])->count();
    }

    /**
     * Общий доход за эту неделю
     * @return int
     */
    public function totalProfitThisWeek(): int
    {
        return array_sum($this->profitThisWeek());
    }

    /**
     * Общий доход за прошлую неделю
     * @return int
     */
    public function totalProfitLastWeek(): int
    {
        return array_sum($this->profitLastWeek());
    }

    /**
     * Общее кол-во заявок за прошлую неделю
     * @return int
     */
    public function totalQtyLastWeek(): int
    {
        return array_sum($this->qtyLastWeek());
    }

    /**
     * Общее кол-во заявок за текущую неделю
     * @return int
     */
    public function totalQtyThisWeek(): int
    {
        return array_sum($this->qtyThisWeek());
    }

    /**
     * Средняя стоимость одной заявки за прошедшую неделю
     * @return float|int
     */
    public function avgProfitLastWeek()
    {
        return ($this->qtyLastWeek()>0) ? $this->totalProfitLastWeek() / $this->totalQtyLastWeek() : 0;
    }

    /**
     * Средняя стоимость одной заявки за эту неделю
     * @return float|int
     */
    public function avgProfitThisWeek()
    {
        return ($this->totalQtyThisWeek()>0) ? $this->totalProfitThisWeek() / $this->totalQtyThisWeek() : 0;
    }

    /**
     * Процентное отношение общего дохода
     * @return float|int
     */
    public function percentBetweenProfitWeek()
    {
        if ($this->totalProfitLastWeek() < $this->totalProfitThisWeek())
        {
            return ($this->totalProfitThisWeek()>0) ? (100-$this->totalProfitLastWeek()/$this->totalProfitThisWeek()*100)  : 0;
        }
        else
        {
            return -(($this->totalProfitLastWeek()>0) ? (100-$this->totalProfitThisWeek()/$this->totalProfitLastWeek()*100)  : 0);
        }
    }

    /**
     * Процентное отношение средней стоимости заявки
     * @return float|int
     */
    public function percentBetweenAvgProfitWeek()
    {
        if ($this->avgProfitLastWeek() < $this->avgProfitThisWeek())
        {
            return ($this->avgProfitThisWeek()>0) ? (100-$this->avgProfitLastWeek()/$this->avgProfitThisWeek()*100)  : 0;
        }
        else
        {
            return -(($this->avgProfitLastWeek()>0) ? (100-$this->avgProfitThisWeek()/$this->avgProfitLastWeek()*100)  : 0);
        }
    }

    /**
     * Процентное отношение количества заявок
     * @return float|int
     */
    public function percentBetweenQtyWeek()
    {
        if ($this->totalQtyLastWeek() < $this->totalQtyThisWeek())
        {
            return ($this->totalQtyThisWeek()>0) ? (100-$this->totalQtyLastWeek()/$this->totalQtyThisWeek()*100)  : 0;
        }
        else
        {
            return -(($this->totalQtyLastWeek()>0) ? (100-$this->totalQtyThisWeek()/$this->totalQtyLastWeek()*100)  : 0);
        }
    }

    /**
     * Сумма дохода по дням недели за текущую неделю, массив из 7 значений по дням
     * @return int[]
     */
    public function profitThisWeek(): array
    {
        if (!$this->_profitThisWeek)
        {
            $this->_profitThisWeek = $this->profitByWeek(
                new \DateTime('Monday this week'),
                new \DateTime('Tuesday this week'),
                new \DateTime('Wednesday this week'),
                new \DateTime('Thursday this week'),
                new \DateTime('Friday this week'),
                new \DateTime('Saturday this week'),
                new \DateTime('Sunday this week')
            );
        }
        return $this->_profitThisWeek;
    }

    /**
     * Сумма дохода по дням недели за прошлую неделю, массив из 7 значений по дням
     * @return int[]
     */
    public function profitLastWeek(): array
    {
        if (!$this->_profitLastWeek)
        {
            $this->_profitLastWeek = $this->profitByWeek(
                new \DateTime('Monday  this week -7 day'),
                new \DateTime('Tuesday  this week -7 day'),
                new \DateTime('Wednesday  this week -7 day'),
                new \DateTime('Thursday  this week -7 day'),
                new \DateTime('Friday  this week -7 day'),
                new \DateTime('Saturday  this week -7 day'),
                new \DateTime('Sunday  this week -7 day')
            );
        }
        return $this->_profitLastWeek;
    }

    /**
     * @return array
     */
    public function qtyThisWeek(): array
    {
        if (!$this->_qtyThisWeek)
        {
            $this->_qtyThisWeek = $this->qtyByWeek(
                new \DateTime('Monday this week'),
                new \DateTime('Tuesday this week'),
                new \DateTime('Wednesday this week'),
                new \DateTime('Thursday this week'),
                new \DateTime('Friday this week'),
                new \DateTime('Saturday this week'),
                new \DateTime('Sunday this week')
            );
        }
        return $this->_qtyThisWeek;
    }

    /**
     * @return array
     */
    public function qtyLastWeek(): array
    {
        if (!$this->_qtyLastWeek)
        {
            $this->_qtyLastWeek = $this->qtyByWeek(
                new \DateTime('Monday  this week -7 day'),
                new \DateTime('Tuesday  this week -7 day'),
                new \DateTime('Wednesday  this week -7 day'),
                new \DateTime('Thursday  this week -7 day'),
                new \DateTime('Friday  this week -7 day'),
                new \DateTime('Saturday  this week -7 day'),
                new \DateTime('Sunday  this week -7 day')
            );
        }
        return $this->_qtyLastWeek;
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
    private function profitByWeek(
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
            Order::find()->where(['DATE(created_at)' => $Monday->format('Y-m-d')])->sum('cost') ?: 0,
            Order::find()->where(['DATE(created_at)' => $Tuesday->format('Y-m-d')])->sum('cost') ?: 0,
            Order::find()->where(['DATE(created_at)' => $Wednesday->format('Y-m-d')])->sum('cost') ?: 0,
            Order::find()->where(['DATE(created_at)' => $Thursday->format('Y-m-d')])->sum('cost') ?: 0,
            Order::find()->where(['DATE(created_at)' => $Friday->format('Y-m-d')])->sum('cost') ?: 0,
            Order::find()->where(['DATE(created_at)' => $Saturday->format('Y-m-d')])->sum('cost') ?: 0,
            Order::find()->where(['DATE(created_at)' => $Sunday->format('Y-m-d')])->sum('cost') ?: 0,
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
     * @return int[]
     */
    private function qtyByWeek(
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