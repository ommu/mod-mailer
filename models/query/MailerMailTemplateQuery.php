<?php
/**
 * MailerMailTemplateQuery
 *
 * This is the ActiveQuery class for [[\ommu\mailer\models\MailerMailTemplate]].
 * @see \ommu\mailer\models\MailerMailTemplate
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 23 May 2018, 10:53 WIB
 * @link https://github.com/ommu/mod-mailer
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
	 * {@inheritdoc}
	 * @return \ommu\mailer\models\MailerMailTemplate[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\mailer\models\MailerMailTemplate|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
