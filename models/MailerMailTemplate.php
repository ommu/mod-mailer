<?php
/**
 * MailerMailTemplate
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 23 May 2018, 10:52 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 * This is the model class for table "ommu_mailer_mail_template".
 *
 * The followings are the available columns in table "ommu_mailer_mail_template":
 * @property string $template
 * @property string $subject
 * @property string $type
 * @property string $header_footer
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
use yii\helpers\Html;
use yii\helpers\Url;
use ommu\users\models\Users;

class MailerMailTemplate extends \app\components\ActiveRecord
{
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = ['header_footer','modified_date','modified_search'];

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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['template', 'subject', 'template_file'], 'required'],
			[['creation_id', 'modified_id'], 'integer'],
			[['type'], 'string'],
			//[['header_footer'], 'serialize'],
			[['creation_date', 'modified_date'], 'safe'],
			[['template', 'subject'], 'string', 'max' => 64],
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
			'type' => Yii::t('app', 'Type'),
			'header_footer' => Yii::t('app', 'Header Footer'),
			'header_footer[header]' => Yii::t('app', 'Header'),
			'header_footer[footer]' => Yii::t('app', 'Footer'),
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
	 * {@inheritdoc}
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

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['template'] = [
			'attribute' => 'template',
			'value' => function($model, $key, $index, $column) {
				return $model->template;
			},
		];
		$this->templateColumns['type'] = [
			'attribute' => 'type',
			'filter' => ['content' => 'Content', 'header' => 'Header', 'footer' => 'Footer'],
			'value' => function($model, $key, $index, $column) {
				return $model->type;
			},
		];
		$this->templateColumns['subject'] = [
			'attribute' => 'subject',
			'value' => function($model, $key, $index, $column) {
				return $model->subject;
			},
		];
		$this->templateColumns['header_footer'] = [
			'attribute' => 'header_footer',
			'value' => function($model, $key, $index, $column) {
				return serialize($model->header_footer);
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
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creation_search'] = [
				'attribute' => 'creation_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
					// return $model->creationDisplayname;
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modified_search'] = [
				'attribute' => 'modified_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
					// return $model->modifiedDisplayname;
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
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
			$model = $model->where(['template' => $template])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($template);
			return $model;
		}
	}

	/**
	 * function getTemplate
	 */
	public static function getTemplate($type=null,$array=true) 
	{
		$model = self::find()->alias('t');
		if($type == null)
			$model->andWhere(['t.type' => 'content']);
		else
			$model->andWhere(['t.type' => $type]);

		$model = $model->orderBy('t.template ASC')->all();

		if($array == true) {
			$items = [];
			if($model !== null) {
				foreach($model as $val) {
					$items[$val->template] = $val->template;
				}
				return $items;
			} else
				return false;
		} else 
			return $model;
	}

	/**
	 * @param returnAlias set true jika ingin kembaliannya path alias atau false jika ingin string
	 * relative path. default true.
	 */
	public static function getUploadPath($returnAlias=true) 
	{
		return ($returnAlias ? Yii::getAlias('@public/email') : 'email');
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		$this->header_footer = unserialize($this->header_footer);
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			} else {
				if($this->modified_id == null)
					$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}

			if($this->type != 'content')
				$this->subject = '-';
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
			$this->header_footer = serialize($this->header_footer);
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
