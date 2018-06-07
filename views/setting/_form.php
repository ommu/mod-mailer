<?php
/**
 * Mailer Settings (mailer-setting)
 * @var $this yii\web\View
 * @var $this ommu\mailer\controllers\SettingController
 * @var $model ommu\mailer\models\MailerSetting
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 6 May 2018, 16:46 WIB
 * @link http://ecc.ft.ugm.ac.id
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
	$this->registerJs($js, \yii\web\View::POS_READY);
?>

<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'form-horizontal form-label-left',
		//'enctype' => 'multipart/form-data',
	],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'mail_contact', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}<span class="small-px">'.Yii::t('app', 'Enter the email address you want contact form messages to be sent to.').'</span></div>'])
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('mail_contact'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'mail_name', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}<span class="small-px">'.Yii::t('app', 'Enter the name you want the emails from the system to come from in the field below.').'</span></div>'])
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('mail_name'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'mail_from', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}<span class="small-px">'.Yii::t('app', 'Enter the email address you want the emails from the system to come from in the field below.').'</span></div>'])
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('mail_from'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'mail_count', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}<span class="small-px">'.Yii::t('app', 'The number of emails to send out each time the Background Mailer task is run.').'</span></div>'])
	->textInput(['type' => 'number', 'min' => '1', 'maxlength' => true])
	->label($model->getAttributeLabel('mail_count'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php 
$mail_queueing = [
	1 => Yii::t('app', 'Yes, enable email queue'),
	0 => Yii::t('app', 'No, always send emails immediately'),
];
echo $form->field($model, 'mail_queueing', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Utilizing an email queue, you can allow your website to throttle the emails being sent out to prevent overloading the mail server.').'</span>{input}{error}</div>'])
	->radioList($mail_queueing, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('mail_queueing'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php 
$mail_smtp = [
	0 => Yii::t('app', 'Use the built-in mail() function'),
	1 => Yii::t('app', 'Send emails through an SMTP server'),
];
echo $form->field($model, 'mail_smtp', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Emails typically get sent through the web server using the PHP mail() function. Alternatively you can have emails sent out using SMTP, usually requiring a username and password, and optionally using an external mail server.').'</span>{input}{error}</div>'])
	->radioList($mail_smtp, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('mail_smtp'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<div id="smtp" <?php echo !$model->mail_smtp ? 'style="display: none;"' : ''; ?>>
	<?php echo $form->field($model, 'smtp_address', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}</div>'])
		->textInput(['maxlength' => true])
		->label($model->getAttributeLabel('smtp_address'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

	<?php echo $form->field($model, 'smtp_port', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}<span class="small-px">'.Yii::t('app', 'Default: 25. Also commonly on port 465 (SMTP over SSL) or port 587.').'</span></div>'])
		->textInput(['maxlength' => true])
		->label($model->getAttributeLabel('smtp_port'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

	<?php 
	$smtp_authentication = [
		1 => Yii::t('app', 'Yes'),
		0 => Yii::t('app', 'No'),
	];
	echo $form->field($model, 'smtp_authentication', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Does your SMTP Server require authentication?').'</span>{input}{error}</div>'])
		->radioList($smtp_authentication, ['class'=>'desc pt-10', 'separator' => '<br />'])
		->label($model->getAttributeLabel('smtp_authentication'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

	<div id="authentication" <?php echo !$model->smtp_authentication ? 'style="display: none;"' : ''; ?>>
		<?php echo $form->field($model, 'smtp_username', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}</div>'])
			->textInput(['maxlength' => true])
			->label($model->getAttributeLabel('smtp_username'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

		<?php echo $form->field($model, 'smtp_password', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}</div>'])
			->textInput(['maxlength' => true])
			->label($model->getAttributeLabel('smtp_password'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
	</div>

	<?php 
	$smtp_ssl = [
		0 => Yii::t('app', 'None'),
		1 => Yii::t('app', 'TLS'),
		2 => Yii::t('app', 'SSL'),
	];
	echo $form->field($model, 'smtp_ssl', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}</div>'])
		->radioList($smtp_ssl, ['class'=>'desc pt-10', 'separator' => '<br />'])
		->label($model->getAttributeLabel('smtp_ssl'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
</div>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>