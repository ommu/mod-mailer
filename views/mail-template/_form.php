<?php
/**
 * Mailer Mail Templates (mailer-mail-template)
 * @var $this app\components\View
 * @var $this ommu\mailer\controllers\MailTemplateController
 * @var $model ommu\mailer\models\MailerMailTemplate
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 23 May 2018, 10:56 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\mailer\models\MailerMailTemplate;

$js = <<<JS
	$('.field-type select[name="type"]').on('change', function() {
		var id = $(this).val();
		if(id != 'content') {
			$('div#header_footer').slideUp();
		} else {
			$('div#header_footer').slideDown();
		}
	});
JS;
	$this->registerJs($js, \app\components\View::POS_READY);
?>

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'type')
	->dropDownList(['content' => 'Content', 'header' => 'Header', 'footer' => 'Footer'])
	->label($model->getAttributeLabel('type')); ?>

<div id="header_footer" class="mb-10">
	<?php echo $form->field($model, 'subject')
		->textInput(['maxlength'=>true])
		->label($model->getAttributeLabel('subject')); ?>
		
	<?php 
	$header = MailerMailTemplate::getTemplate('header');
	echo $form->field($model, 'header_footer[header]')
		->dropDownList($header, ['prompt'=>''])
		->label($model->getAttributeLabel('header_footer[header]')); ?>
		
	<?php 
	$footer = MailerMailTemplate::getTemplate('footer');
	echo $form->field($model, 'header_footer[footer]')
		->dropDownList($footer, ['prompt'=>''])
		->label($model->getAttributeLabel('header_footer[footer]')); ?>
</div>

<?php echo $form->field($model, 'template_file')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('template_file')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>