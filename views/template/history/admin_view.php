<?php
/**
 * Mailer Mail Template Histories (mailer-mail-template-history)
 * @var $this app\components\View
 * @var $this ommu\mailer\controllers\template\HistoryController
 * @var $model ommu\mailer\models\MailerMailTemplateHistory
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 30 May 2018, 03:41 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Tools'), 'url' => ['/admin/module/manage']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mail Template'), 'url' => ['template/admin/manage']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'History'), 'url' => ['manage']];
$this->params['breadcrumbs'][] = $this->title;

if (!$small) {
    $this->params['menu']['content'] = [
        ['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id' => $model->id]), 'htmlOptions' => ['data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method' => 'post', 'class' => 'btn btn-danger'], 'icon' => 'trash'],
    ];
} ?>

<?php
$attributes = [
    'id',
    [
        'attribute' => 'template_search',
        'value' => isset($model->templateRltn) ? $model->templateRltn->template : '-',
    ],
    'template_file',
    [
        'attribute' => 'creation_date',
        'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
        'visible' => !$small,
    ],
    [
        'attribute' => 'creationDisplayname',
        'value' => isset($model->creation) ? $model->creation->displayname : '-',
    ],
];

echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class' => 'table table-striped detail-view',
	],
	'attributes' => $attributes,
]); ?>