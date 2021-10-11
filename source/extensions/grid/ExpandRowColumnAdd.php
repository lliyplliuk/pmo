<?php


namespace app\extensions\grid;


use kartik\grid\ExpandRowColumn;

class ExpandRowColumnAdd extends ExpandRowColumn
{

    public $label;

    /**
     * @inheritdoc
     */
    protected function renderHeaderCellContent()
    {
        $header=parent::renderHeaderCellContent();
        return $header."<span style='font-size: 16px;'>$this->label</span>";
    }
}