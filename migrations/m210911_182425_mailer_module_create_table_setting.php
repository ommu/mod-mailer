<?php
/**
 * m210911_182425_mailer_module_create_table_setting
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 11 September 2021, 18:24 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\db\Schema;

class m210911_182425_mailer_module_create_table_setting extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_setting';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_TINYINT . '(1) UNSIGNED NOT NULL AUTO_INCREMENT',
				'mail_contact' => Schema::TYPE_STRING . '(64) NOT NULL',
				'mail_name' => Schema::TYPE_STRING . '(64) NOT NULL',
				'mail_from' => Schema::TYPE_STRING . '(64) NOT NULL',
				'mail_count' => Schema::TYPE_SMALLINT . '(5) NOT NULL DEFAULT \'0\'',
				'mail_queueing' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'1\'',
				'mail_smtp' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'0\'',
				'smtp_address' => Schema::TYPE_STRING . '(32) NOT NULL',
				'smtp_port' => Schema::TYPE_STRING . '(16) NOT NULL DEFAULT \'25\'',
				'smtp_authentication' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'0\'',
				'smtp_username' => Schema::TYPE_STRING . '(32) NOT NULL',
				'smtp_password' => Schema::TYPE_STRING . '(32) NOT NULL',
				'smtp_ssl' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'0\'',
				'blasting_delimiter_file' => Schema::TYPE_CHAR . '(1) NOT NULL',
				'blasting_cronjob_limit' => Schema::TYPE_SMALLINT . '(5) NOT NULL',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[id]])',
			], $tableOptions);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_setting';
		$this->dropTable($tableName);
	}
}
