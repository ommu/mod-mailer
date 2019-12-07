<?php
/**
 * Mailer Settings (mailer-setting)
 * @var $this app\components\View
 * @var $this ommu\mailer\controllers\SettingController
 * @var $model ommu\mailer\models\MailerSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 6 May 2018, 16:46 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;

$js = <<<JS
	$('.field-mail_smtp input[name="mail_smtp"]').on('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#smtp').slideDown();
		} else {
			$('div#smtp').slideUp();
		}
	});
	$('.field-smtp_authentication input[name="smtp_authentication"]').on('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#authentication').slideDown();
		} else {
			$('div#authentication').slideUp();
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

<?php echo $form->field($model, 'mail_contact')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mail_contact'))
	->hint(Yii::t('app', 'Enter the email address you want contact form messages to be sent to.')); ?>

<?php echo $form->field($model, 'mail_name')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mail_name'))
	->hint(Yii::t('app', 'Enter the name you want the emails from the system to come from in the field below.')); ?>

<?php echo $form->field($model, 'mail_from')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mail_from'))
	->hint(Yii::t('app', 'Enter the email address you want the emails from the system to come from in the field below.')); ?>

<?php echo $form->field($model, 'mail_count')
	->textInput(['type' => 'number', 'min' => '1', 'maxlength' => true])
	->label($model->getAttributeLabel('mail_count'))
	->hint(Yii::t('app', 'The number of emails to send out each time the Background Mailer task is run.')); ?>

<?php 
$mail_queueing = [
	1 => Yii::t('app', 'Yes, enable email queue'),
	0 => Yii::t('app', 'No, always send emails immediately'),
];
echo $form->field($model, 'mail_queueing', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($mail_queueing)
	->label($model->getAttributeLabel('mail_queueing'))
	->hint(Yii::t('app', 'Utilizing an email queue, you can allow your website to throttle the emails being sent out to prevent overloading the mail server.')); ?>

<?php 
$mail_smtp = [
	0 => Yii::t('app', 'Use the built-in mail() function'),
	1 => Yii::t('app', 'Send emails through an SMTP server'),
];
echo $form->field($model, 'mail_smtp', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($mail_smtp)
	->label($model->getAttributeLabel('mail_smtp'))
	->hint(Yii::t('app', 'Emails typically get sent through the web server using the PHP mail() function. Alternatively you can have emails sent out using SMTP, usually requiring a username and password, and optionally using an external mail server.')); ?>

<div id="smtp" <?php echo !$model->mail_smtp ? 'style="display: none;"' : ''; ?>>
	<?php echo $form->field($model, 'smtp_address')
		->textInput(['maxlength'=>true])
		->label($model->getAttributeLabel('smtp_address')); ?>

	<?php echo $form->field($model, 'smtp_port')
		->textInput(['maxlength'=>true])
		->label($model->getAttributeLabel('smtp_port'))
		->hint(Yii::t('app', 'Default: 25. Also commonly on port 465 (SMTP over SSL) or port 587.')); ?>

	<?php 
	$smtp_authentication = [
		1 => Yii::t('app', 'Yes'),
		0 => Yii::t('app', 'No'),
	];
	echo $form->field($model, 'smtp_authentication', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($smtp_authentication)
		->label($model->getAttributeLabel('smtp_authentication'))
		->hint(Yii::t('app', 'Does your SMTP Server require authentication?')); ?>

	<div id="authentication" <?php echo !$model->smtp_authentication ? 'style="display: none;"' : ''; ?>>
		<?php echo $form->field($model, 'smtp_username')
			->textInput(['maxlength'=>true])
			->label($model->getAttributeLabel('smtp_username')); ?>

		<?php echo $form->field($model, 'smtp_password')
			->textInput(['maxlength'=>true])
			->label($model->getAttributeLabel('smtp_password')); ?>
	</div>

	<?php 
	$smtp_ssl = [
		0 => Yii::t('app', 'None'),
		1 => Yii::t('app', 'TLS'),
		2 => Yii::t('app', 'SSL'),
	];
	echo $form->field($model, 'smtp_ssl')
		->radioList($smtp_ssl)
		->label($model->getAttributeLabel('smtp_ssl')); ?>
</div>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>