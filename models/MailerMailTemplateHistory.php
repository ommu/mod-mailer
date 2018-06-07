<?php
/**
 * MailerMailTemplateHistory
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 30 May 2018, 03:37 WIB
 * @link https://ecc.ft.ugm.ac.id
 *
 * This is the model class for table "ommu_mailer_mail_template_history".
 *
 * The followings are the available columns in table "ommu_mailer_mail_template_history":
 * @property integer $id
 * @property string $template
 * @property string $template_file
 * @property string $creation_date
 * @property integer $creation_id
 *
 * The followings are the available model relations:
 * @property MailerMailTemplate $template0
 * @property Users $creation
 *
 */

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use ommu\users\models\Users;

class MailerMailTemplateHistory extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	// Variable Search
	public $template_search;
	public $creation_search;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_mailer_mail_template_history';
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
			[['template', 'template_file'], 'required'],
			[['creation_id'], 'integer'],
			[['creation_date'], 'safe'],
			[['template'], 'string', 'max' => 64],
			[['template_file'], 'string', 'max' => 32],
			[['template'], 'exist', 'skipOnError' => true, 'targetClass' => MailerMailTemplate::className(), 'targetAttribute' => ['template' => 'template']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'template' => Yii::t('app', 'Template'),
			'template_file' => Yii::t('app', 'Template File'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'template_search' => Yii::t('app', 'Template'),
			'creation_search' => Yii::t('app', 'Creation'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTemplateRltn()
	{
		return $this->hasOne(MailerMailTemplate::className(), ['template' => 'template']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * @inheritdoc
	 * @return \ommu\mailer\models\query\MailerMailTemplateHistoryQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\mailer\models\query\MailerMailTemplateHistoryQuery(get_called_class());
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
		if(!Yii::$app->request->get('template')) {
			$this->templateColumns['template_search'] = [
				'attribute' => 'template_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->template) ? $model->templateRltn->template : '-';
				},
			];
		}
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
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
		}
		return true;
	}
}
