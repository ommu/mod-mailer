<?php
/**
 * MailerMailTemplateQuery
 *
 * This is the ActiveQuery class for [[\ommu\mailer\models\MailerMailTemplate]].
 * @see \ommu\mailer\models\MailerMailTemplate
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 23 May 2018, 10:53 WIB
 * @link https://ecc.ft.ugm.ac.id
 *
 */

namespace ommu\mailer\models\query;

class MailerMailTemplateQuery extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * @inheritdoc
	 * @return \ommu\mailer\models\MailerMailTemplate[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return \ommu\mailer\models\MailerMailTemplate|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
