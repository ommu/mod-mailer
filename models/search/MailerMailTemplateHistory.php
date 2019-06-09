<?php
/**
 * MailerMailTemplateHistory
 *
 * MailerMailTemplateHistory represents the model behind the search form about `ommu\mailer\models\MailerMailTemplateHistory`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 30 May 2018, 03:41 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

namespace ommu\mailer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\mailer\models\MailerMailTemplateHistory as MailerMailTemplateHistoryModel;

class MailerMailTemplateHistory extends MailerMailTemplateHistoryModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'creation_id'], 'integer'],
			[['template', 'template_file', 'creation_date',
				'template_search', 'creation_search'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Tambahkan fungsi beforeValidate ini pada model search untuk menumpuk validasi pd model induk. 
	 * dan "jangan" tambahkan parent::beforeValidate, cukup "return true" saja.
	 * maka validasi yg akan dipakai hanya pd model ini, semua script yg ditaruh di beforeValidate pada model induk
	 * tidak akan dijalankan.
	 */
	public function beforeValidate() {
		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search($params, $column=null)
	{
		if(!($column && is_array($column)))
			$query = MailerMailTemplateHistoryModel::find()->alias('t');
		else
			$query = MailerMailTemplateHistoryModel::find()->alias('t')->select($column);
		$query->joinWith([
			'templateRltn templateRltn', 
			'creation creation'
		]);

		// add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['template_search'] = [
			'asc' => ['templateRltn.template' => SORT_ASC],
			'desc' => ['templateRltn.template' => SORT_DESC],
		];
		$attributes['creation_search'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['id' => SORT_DESC],
		]);

		if(Yii::$app->request->get('id'))
			unset($params['id']);
		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.id' => $this->id,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
		]);

		$query->andFilterWhere(['like', 't.template', $this->template])
			->andFilterWhere(['like', 't.template_file', $this->template_file])
			->andFilterWhere(['like', 'templateRltn.template', $this->template_search])
			->andFilterWhere(['like', 'creation.displayname', $this->creation_search]);

		return $dataProvider;
	}
}
