<?php
/**
 * m230604_153916_mailerModule_createTable_blastingTargetNonMember
 * 
 * @author Putra Sudaryanto <dwptr@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2023 OMMU (www.ommu.id)
 * @created date 4 June 2023, 15:39 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\db\Schema;

class m230604_153916_mailerModule_createTable_blastingTargetNonMember extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_blasting_target_non_member';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'message_id' => Schema::TYPE_STRING . '(36) NOT NULL',
				'unique_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
				'name' => Schema::TYPE_STRING . '(64) NOT NULL',
				'email' => Schema::TYPE_STRING . '(64) NOT NULL',
				'status' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'0\' COMMENT \'0=pending, 1=send\'',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
				'updated_date' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT \'0000-00-00 00:00:00\'',
				'PRIMARY KEY ([[message_id]], [[unique_id]])',
				'CONSTRAINT ommu_mailer_blasting_target_non_member_ibfk_1 FOREIGN KEY ([[message_id]]) REFERENCES ommu_mailer_blasting_messages ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
			], $tableOptions);

			$this->createIndex(
				'unique_id',
				$tableName,
				['unique_id']
			);

			$this->createIndex(
				'email',
				$tableName,
				['email']
			);

			$this->createIndex(
				'status',
				$tableName,
				['status']
			);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_mailer_blasting_target_non_member';
		$this->dropTable($tableName);
	}
}
