<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropDown;
use yii\bootstrap\Alert;

$this->registerJs('
    function alert(message, type) {
        var button = $("<button>", {
            type: "button",
            class: "close",
            "data-dismiss": "alert",
            "aria-hidden": "true",
            text: "x"
        });
        var alert = $("<div>", {
            class: "alert alert-"+type+" fade in",
        }).append(button).append(message);
        $("#alert").empty().html(alert);
    }
    
    $("#grid").on("click", ".changeDirectionBtn", function(e){
        var self = $(this),
            direction = self.data("direction"),
            menuId = self.data("pid");

        $.post("'.Url::to(['move']).'", {node_id: menuId, direction: direction}, function(data){
            if (data.status === "success") {
                $("#grid").empty().html(data.grid);
            }
            var type = data.status == "error" ? "danger" : data.status;
            alert(data.message, type);
        }, "json");

        e.preventDefault();
    });
');

Yii::$app->toolbar->add()->add(Yii::t('cms', 'Edit menus'), ['menus'], 'bars');

$title = Yii::t('cms', 'Menu items');
$this->title = Yii::$app->id . ' | ' . $title;
?>

<div class="row">
    <div class="col-md-12">
        <div id="alert">
        </div>
        
        <h1><?= $title ?></h1>
        
        <?= ButtonDropDown::widget([
            'label' => Yii::t('cms', 'Select menu'),
            'options' => ['class' => 'btn btn-default', 'style' => 'margin-bottom: 10px;'],
            'dropdown' => [
                'items' => $dropdown,
            ],
        ]) ?>
        
        <div id="grid">
            <?= $this->render('_grid', ['dataProvider' => $dataProvider]); ?>
        </div>
    </div>
</div>