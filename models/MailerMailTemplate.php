<?php
/**
 * MailerMailTemplate
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 23 May 2018, 10:52 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 * This is the model class for table "ommu_mailer_mail_template".
 *
 * The followings are the available columns in table "ommu_mailer_mail_template":
 * @property string $template
 * @property string $subject
 * @property string $template_file
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property MailerMailTemplateHistory[] $histories
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\mailer\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use ommu\users\models\Users;

class MailerMailTemplate extends \app\components\ActiveRecord
{
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = ['modified_date','modified_search'];

	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_mailer_mail_template';
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
			[['template, subject', 'template_file'], 'required'],
			[['creation_id', 'modified_id'], 'integer'],
			[['creation_date', 'modified_date'], 'safe'],
			[['template, subject'], 'string', 'max' => 64],
			[['template_file'], 'string', 'max' => 32],
			[['template'], 'unique'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'template' => Yii::t('app', 'Template'),
			'subject' => Yii::t('app', 'Email Subject'),
			'template_file' => Yii::t('app', 'Template File'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'creation_search' => Yii::t('app', 'Creation'),
			'modified_search' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getHistories()
	{
		return $this->hasMany(MailerMailTemplateHistory::className(), ['template' => 'template']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * @inheritdoc
	 * @return \ommu\mailer\models\query\MailerMailTemplateQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\mailer\models\query\MailerMailTemplateQuery(get_called_class());
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
		$this->templateColumns['template'] = [
			'attribute' => 'template',
			'value' => function($model, $key, $index, $column) {
				return $model->template;
			},
		];
		$this->templateColumns['subject'] = [
			'attribute' => 'subject',
			'value' => function($model, $key, $index, $column) {
				return $model->subject;
			},
		];
		$this->templateColumns['template_file'] = [
			'attribute' => 'template_file',
			'value' => function($model, $key, $index, $column) {
				return $model->template_file;
			},
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'filter' => Html::input('date', 'creation_date', Yii::$app->request->get('creation_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->creation_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->creation_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creation_search'] = [
				'attribute' => 'creation_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
				},
			];
		}
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
	}

	/**
	 * User get information
	 */
	public static function getInfo($template, $column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['template' => $template])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($template);
			return $model;
		}
	}

	/**
	 * @param returnAlias set true jika ingin kembaliannya path alias atau false jika ingin string
	 * relative path. default true.
	 */
	public static function getUploadPath($returnAlias=true) 
	{
		return ($returnAlias ? Yii::getAlias('@webroot/public/email') : 'public/email');
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			else
				$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
		}
		return true;
	}

	/**
	 * after validate attributes
	 */
	public function afterValidate()
	{
		parent::afterValidate();

		// Create action
		
		return true;
	}

	/**
	 * before save attributes
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			if($insert) {
				$uploadPath = self::getUploadPath();
				$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
				$this->createUploadDirectory(self::getUploadPath());
			}
		}
		return true;
	}

	/**
	 * After save attributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
			
		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
		$this->createUploadDirectory(self::getUploadPath());
	}

	/**
	 * Before delete attributes
	 */
	public function beforeDelete()
	{
		if(parent::beforeDelete()) {
			// Create action
		}
		return true;
	}

	/**
	 * After delete attributes
	 */
	public function afterDelete()
	{
		parent::afterDelete();

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);

		if($this->template != '' && file_exists(join('/', [$uploadPath, $this->template])))
			rename(join('/', [$uploadPath, $this->template]), join('/', [$verwijderenPath, time().'_'.$this->template]));
	}
}