<?php
/**
 * Events
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->searchGrid(),
    'enableSorting' => TRUE,
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'UserId',
            'name' => 'userid',
            'visible' => FALSE,
        ),
        array(
            'header' => 'Name',
            'class' => 'CDataColumn',
            'type' => 'raw',
            'name'=> 'name',
            'value' => 'CHtml::link($data->name, array("admin/user", "id"=>$data->userid))',
        ),
        array(
            'header' => 'Alias',
            'name' => 'alias'
        ),
        array(
            'header' => 'Email',
            'name' => 'email'
        ),
    ),
));