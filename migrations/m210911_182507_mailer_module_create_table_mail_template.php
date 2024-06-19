<?php
/**
 * m210911_182507_mailer_module_create_table_mail_template
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 11 September 2021, 18:25 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\db\Schema;

class m210911_182507_mailer_module_create_table_mail_template extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_mail_template';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'template' => Schema::TYPE_STRING . '(64) NOT NULL',
				'subject' => Schema::TYPE_STRING . '(64) NOT NULL',
				'type' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'content\'',
				'header_footer' => Schema::TYPE_TEXT . ' COMMENT \'serialize\'',
				'template_file' => Schema::TYPE_STRING . '(32) NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[template]])',
			], $tableOptions);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_mail_template';
		$this->dropTable($tableName);
	}
}
