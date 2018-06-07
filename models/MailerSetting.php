<?php
/**
 * MailerSetting
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 6 May 2018, 16:46 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 * This is the model class for table "ommu_mailer_setting".
 *
 * The followings are the available columns in table "ommu_mailer_setting":
 * @property integer $id
 * @property string $mail_contact
 * @property string $mail_name
 * @property string $mail_from
 * @property integer $mail_count
 * @property integer $mail_queueing
 * @property integer $mail_smtp
 * @property string $smtp_address
 * @property string $smtp_port
 * @property integer $smtp_authentication
 * @property string $smtp_username
 * @property string $smtp_password
 * @property integer $smtp_ssl
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property Users $modified
 *
 */

namespace ommu\mailer\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use ommu\users\models\Users;

class MailerSetting extends \app\components\ActiveRecord
{
	use \ommu\traits\GridViewTrait;

	public $gridForbiddenColumn = [];

	// Variable Search
	public $modified_search;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_mailer_setting';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('ecc4');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['mail_contact', 'mail_name', 'mail_from', 'mail_count', 'mail_queueing', 'mail_smtp'], 'required'],
			[['mail_count', 'mail_queueing', 'mail_smtp', 'smtp_authentication', 'smtp_ssl', 'modified_id'], 'integer'],
			[['smtp_address', 'smtp_username', 'smtp_password', 'modified_date'], 'safe'],
			[['mail_contact', 'mail_name', 'mail_from', 'smtp_address', 'smtp_username', 'smtp_password'], 'string', 'max' => 32],
			[['smtp_port'], 'string', 'max' => 16],
			[['mail_count'], 'string', 'max' => 3],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'mail_contact' => Yii::t('app', 'Contact Form Email'),
			'mail_name' => Yii::t('app', 'From Name'),
			'mail_from' => Yii::t('app', 'From Address'),
			'mail_count' => Yii::t('app', 'Mail Count'),
			'mail_queueing' => Yii::t('app', 'Mail Queueing'),
			'mail_smtp' => Yii::t('app', 'Send through SMTP'),
			'smtp_address' => Yii::t('app', 'SMTP Server Address'),
			'smtp_port' => Yii::t('app', 'SMTP Server Port'),
			'smtp_authentication' => Yii::t('app', 'SMTP Authentication?'),
			'smtp_username' => Yii::t('app', 'SMTP Username'),
			'smtp_password' => Yii::t('app', 'SMTP Password'),
			'smtp_ssl' => Yii::t('app', 'Use SSL or TLS?'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'modified_search' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * Set default columns to display
	 */
	public function init() 
	{
		parent::init();

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class'  => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['mail_contact'] = [
			'attribute' => 'mail_contact',
			'value' => function($model, $key, $index, $column) {
				return $model->mail_contact;
			},
		];
		$this->templateColumns['mail_name'] = [
			'attribute' => 'mail_name',
			'value' => function($model, $key, $index, $column) {
				return $model->mail_name;
			},
		];
		$this->templateColumns['mail_from'] = [
			'attribute' => 'mail_from',
			'value' => function($model, $key, $index, $column) {
				return $model->mail_from;
			},
		];
		$this->templateColumns['mail_count'] = [
			'attribute' => 'mail_count',
			'value' => function($model, $key, $index, $column) {
				return $model->mail_count;
			},
		];
		$this->templateColumns['smtp_address'] = [
			'attribute' => 'smtp_address',
			'value' => function($model, $key, $index, $column) {
				return $model->smtp_address;
			},
		];
		$this->templateColumns['smtp_port'] = [
			'attribute' => 'smtp_port',
			'value' => function($model, $key, $index, $column) {
				return $model->smtp_port;
			},
		];
		$this->templateColumns['smtp_username'] = [
			'attribute' => 'smtp_username',
			'value' => function($model, $key, $index, $column) {
				return $model->smtp_username;
			},
		];
		$this->templateColumns['smtp_password'] = [
			'attribute' => 'smtp_password',
			'value' => function($model, $key, $index, $column) {
				return $model->smtp_password;
			},
		];
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'filter' => Html::input('date', 'modified_date', Yii::$app->request->get('modified_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modified_search'] = [
				'attribute' => 'modified_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
				},
			];
		}
		$this->templateColumns['mail_queueing'] = [
			'attribute' => 'mail_queueing',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->mail_queueing ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['mail_smtp'] = [
			'attribute' => 'mail_smtp',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->mail_smtp ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['smtp_authentication'] = [
			'attribute' => 'smtp_authentication',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->smtp_authentication ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['smtp_ssl'] = [
			'attribute' => 'smtp_ssl',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->smtp_ssl ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['id' => 1])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne(1);
			return $model;
		}
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if(!$this->isNewRecord)
				$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
				
			if($this->mail_smtp) {
				if($this->smtp_address == '')
					$this->addError('smtp_address', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('smtp_address')]));
				
				if($this->smtp_port == '')
					$this->addError('smtp_port', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('smtp_port')]));

				if($this->smtp_ssl == '')
					$this->addError('smtp_ssl', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('smtp_ssl')]));
				
				if($this->smtp_authentication) {
					if($this->smtp_username == '')
						$this->addError('smtp_username', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('smtp_username')]));

					if($this->smtp_password == '')
						$this->addError('smtp_password', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('smtp_password')]));
				}
			}
		}
		return true;
	}
}