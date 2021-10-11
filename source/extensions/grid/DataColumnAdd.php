<?php


namespace app\extensions\grid;


use kartik\grid\DataColumn;
use yii\bootstrap4\Html;

class DataColumnAdd extends DataColumn
{
    public array $style;

    /**
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        $options = $this->fetchContentOptions($model, $key, $index);
        $this->parseGrouping($options, $model, $key, $index);
        $this->parseExcelFormats($options, $model, $key, $index);
        $this->initPjax($this->_clientScript);
        if (!empty($this->style)) {
            $options = array_merge($options, ['style' => $this->style]);
        }
        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
    }
}