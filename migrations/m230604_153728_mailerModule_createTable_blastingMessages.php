<?php
/**
 * m230604_153728_mailerModule_createTable_blastingMessages
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2023 OMMU (www.ommu.id)
 * @created date 4 June 2023, 15:37 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\db\Schema;

class m230604_153728_mailerModule_createTable_blastingMessages extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_blasting_messages';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_STRING . '(36) NOT NULL DEFAULT \'uuid()\'',
				'publish' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'1\'',
				'from_name' => Schema::TYPE_STRING . '(64) NOT NULL',
				'from_email' => Schema::TYPE_STRING . '(64) NOT NULL',
				'subject' => Schema::TYPE_STRING . '(64) NOT NULL',
				'message_orig' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'redactor\'',
				'message_blas' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'redactor\'',
				'attachment' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'json\'',
				'template' => Schema::TYPE_TEXT . ' NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
				'creation_id' => Schema::TYPE_INTEGER . '(11)',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11)',
				'updated_date' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT \'0000-00-00 00:00:00\'',
				'PRIMARY KEY ([[id]])',
			], $tableOptions);

			$this->createIndex(
				'publish',
				$tableName,
				['publish']
			);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_blasting_messages';
		$this->dropTable($tableName);
	}
}
