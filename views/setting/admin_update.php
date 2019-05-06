<?php
/**
 * Mailer Settings (mailer-setting)
 * @var $this app\components\View
 * @var $this ommu\mailer\controllers\SettingController
 * @var $model ommu\mailer\models\MailerSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 6 May 2018, 16:46 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = Yii::t('app', 'Mail Settings');
?>

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>