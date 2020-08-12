<?php


namespace app\models;


use yii\base\Model;

/**
 * Управление шаблонами отчетов.
 * Шаблоны хранятся в папке templates. При первом запуске, в случае отсутствия файла, создается новый файл
 * Class Template
 * @package app\models
 *
 * @property string $content
 * @property string $fullPath
 * @property string $renderPath
 */
class Template extends Model
{

    const ORDER = 1;
    const CLOSE = 2;

    public $name;
    public $filename;
    private $_content;

    private static $templates = [
        '1' => [
            'name' => 'Акт приема',
            'filename' => 'order',
        ],
        '2' => [
            'name' => 'Акт выдачи',
            'filename' => 'close',
        ],
    ];

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
        ];
    }

    /**
     * @return Template|null
     */
    public static function findOrder()
    {
        return isset(self::$templates[self::ORDER]) ? new static(self::$templates[self::ORDER]) : null;
    }

    /**
     * @return Template|null
     */
    public static function findClose()
    {
        return isset(self::$templates[self::CLOSE]) ? new static(self::$templates[self::CLOSE]) : null;
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        return \Yii::getAlias('@app/templates/').$this->filename.'.php';
    }

    /**
     * @return string
     */
    public function getRenderPath()
    {
        return '@app/templates/'.$this->filename;
    }

    /**
     * @return false|string
     */
    public function getContent()
    {
        if (file_exists($this->fullPath))
        {
            $this->_content = ($this->_content) ?: file_get_contents($this->fullPath);
        } else {
            $this->_content = file_put_contents($this->fullPath, '');
        }

        return $this->_content;
    }

    /**
     * @param $value
     */
    public function setContent($value)
    {
        $this->_content = $value;
    }

    /**
     * @return array
     */
    public static function  menuList()
    {
        $items = [];
        foreach (self::$templates as $template)
        {
            $items[] = ['label' => $template['name'], 'icon' => 'file-text-o', 'url' => ['template/'.$template['filename']]];
        }
        return $items;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $result = file_put_contents($this->fullPath, $this->_content);
        if (!$result)
        {
            $this->addError('content', $result);
            return false;
        }
        return  true;
    }

}