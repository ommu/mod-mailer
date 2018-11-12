<?php
/**
 * MailerMailTemplateHistoryQuery
 *
 * This is the ActiveQuery class for [[\ommu\mailer\models\MailerMailTemplateHistory]].
 * @see \ommu\mailer\models\MailerMailTemplateHistory
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 30 May 2018, 03:37 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

namespace ommu\mailer\models\query;

class MailerMailTemplateHistoryQuery extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\mailer\models\MailerMailTemplateHistory[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\mailer\models\MailerMailTemplateHistory|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
