<?php
/**
 * MailerMailTemplate
 *
 * MailerMailTemplate represents the model behind the search form about `ommu\mailer\models\MailerMailTemplate`.
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 23 May 2018, 10:56 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

namespace ommu\mailer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\mailer\models\MailerMailTemplate as MailerMailTemplateModel;

class MailerMailTemplate extends MailerMailTemplateModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['template', 'subject', 'type', 'header_footer', 'template_file', 'creation_date', 'modified_date', 'creationDisplayname', 'modifiedDisplayname'], 'safe'],
			[['creation_id', 'modified_id'], 'integer'],
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
        if (!($column && is_array($column))) {
            $query = MailerMailTemplateModel::find()->alias('t');
        } else {
            $query = MailerMailTemplateModel::find()->alias('t')
                ->select($column);
        }
		$query->joinWith([
			'creation creation', 
			'modified modified'
		]);

		$query->groupBy(['template']);

        // add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['creationDisplayname'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modifiedDisplayname'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['template' => SORT_DESC],
		]);

		$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		// grid filtering conditions
		$query->andFilterWhere([
			't.type' => $this->type,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
		]);

		$query->andFilterWhere(['like', 't.template', $this->template])
			->andFilterWhere(['like', 't.subject', $this->subject])
			->andFilterWhere(['like', 't.header_footer', $this->header_footer])
			->andFilterWhere(['like', 't.template_file', $this->template_file])
			->andFilterWhere(['like', 'creation.displayname', $this->creationDisplayname])
			->andFilterWhere(['like', 'modified.displayname', $this->modifiedDisplayname]);

		return $dataProvider;
	}
}
