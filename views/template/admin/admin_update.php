<?php
/**
 * Mailer Mail Templates (mailer-mail-template)
 * @var $this app\components\View
 * @var $this ommu\mailer\controllers\template\AdminController
 * @var $model ommu\mailer\models\MailerMailTemplate
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 23 May 2018, 10:56 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Tools'), 'url' => ['/admin/module/manage']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mail Template'), 'url' => ['manage']];
$this->params['breadcrumbs'][] = ['label' => $model->template, 'url' => ['view', 'id' => $model->template]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id' => $model->template]), 'icon' => 'eye', 'htmlOptions' => ['class' => 'btn btn-info']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id' => $model->template]), 'htmlOptions' => ['data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method' => 'post', 'class' => 'btn btn-danger'], 'icon' => 'trash'],
];
?>

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>