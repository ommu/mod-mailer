<?php
/**
 * Mailer Settings (mailer-setting)
 * @var $this yii\web\View
 * @var $this app\controllers\SettingController
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
use yii\helpers\Url;

$this->params['breadcrumbs'][] = Yii::t('app', 'Mail Settings');
?>

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>