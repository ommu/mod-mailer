<?php
/**
 * MailerMailTemplateHistory
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 30 May 2018, 03:37 WIB
 * @link https://github.com/ommu/mod-mailer
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

namespace ommu\mailer\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Users;

class MailerMailTemplateHistory extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	// Variable Search
	public $template_search;
	public $creationDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_mailer_mail_template_history';
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
			'creationDisplayname' => Yii::t('app', 'Creation'),
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
	 * {@inheritdoc}
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

        if (!(Yii::$app instanceof \app\components\Application)) {
            return;
        }

        if (!$this->hasMethod('search')) {
            return;
        }

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['template_search'] = [
			'attribute' => 'template_search',
			'value' => function($model, $key, $index, $column) {
				return isset($model->template) ? $model->templateRltn->template : '-';
			},
			'visible' => !Yii::$app->request->get('template') ? true : false,
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
		$this->templateColumns['creationDisplayname'] = [
			'attribute' => 'creationDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->creation) ? $model->creation->displayname : '-';
				// return $model->creationDisplayname;
			},
			'visible' => !Yii::$app->request->get('creation') ? true : false,
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
        if ($column != null) {
            $model = self::find();
            if (is_array($column)) {
                $model->select($column);
            } else {
                $model->select([$column]);
            }
            $model = $model->where(['id' => $id])->one();
            return is_array($column) ? $model : $model->$column;

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
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                if ($this->creation_id == null) {
                    $this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            }
        }
        return true;
	}
}
