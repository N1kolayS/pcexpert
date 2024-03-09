<?php

namespace app\widgets;

use dmstr\widgets\Menu;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Расширение от Меню, для корректной работы с разделителями
 * ['label' => 'Главная', 'icon' => 'cubes', 'url' => ['site/index']],
 * ['label' => 'Текст разделителя', 'header' => true],
 */
class MenuLteWidget extends Menu
{

    /**
     * @var string Шаблон для разделителя
     */
    public string $dividerTemplate = '{label}';

    public string $dividerHeaderClass = 'header';

    public $linkTemplate = '<a href="{url}">{icon} {label} {right_icon}</a>';

    /**
     * @inheritdoc
     */
    protected function renderItem($item): string
    {
        if (isset($item['items'])) {
            $labelTemplate = '<a href="{url}">{icon} {label} <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $linkTemplate = '<a href="{url}">{icon} {label} <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
        } else {
            $labelTemplate = $this->dividerTemplate;
            $linkTemplate = $this->linkTemplate;
        }

        $replacements = [
            '{label}' => isset($item['url']) ?  strtr($this->labelTemplate, ['{label}' => $item['label'],]) : strtr($this->dividerTemplate, ['{label}' => $item['label'],]),
            '{icon}' => empty($item['icon']) ? $this->defaultIconHtml
                : '<i class="' . static::$iconClassPrefix . $item['icon'] . '"></i> ',
            '{url}' => isset($item['url']) ? Url::to($item['url']) : 'javascript:void(0);',
            '{right_icon}' => $item['right_icon'] ?? '',

        ];

        $template = ArrayHelper::getValue($item, 'template', isset($item['url']) ? $linkTemplate : $labelTemplate);

        return strtr($template, $replacements);
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     * @throws \Exception
     */
    protected function renderItems($items): string
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if (isset($item['header'])) {
                $class[] = $this->dividerHeaderClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $menu .= strtr($this->submenuTemplate, [
                    '{show}' => $item['active'] ? "style='display: block'" : '',
                    '{items}' => $this->renderItems($item['items']),
                ]);
                if (isset($options['class'])) {
                    $options['class'] .= ' treeview';
                } else {
                    $options['class'] = 'treeview';
                }
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }


}