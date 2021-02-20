<?php
/**
 * m191116_143100_mailer_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 16 November 2019, 14:31 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use Yii;

class m191116_143100_mailer_module_insert_role extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_auth_item';
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_auth_item', ['name', 'type', 'data', 'created_at'], [
				['mailerModLevelAdmin', '2', '', time()],
				['mailerModLevelModerator', '2', '', time()],
				['/mailer/setting/index', '2', '', time()],
				['/mailer/setting/update', '2', '', time()],
				['/mailer/setting/delete', '2', '', time()],
				['/mailer/template/admin/*', '2', '', time()],
				['/mailer/template/admin/index', '2', '', time()],
				['/mailer/template/history/*', '2', '', time()],
			]);
		}

		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_auth_item_child';
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_auth_item_child', ['parent', 'child'], [
				['userAdmin', 'mailerModLevelAdmin'],
				['userModerator', 'mailerModLevelModerator'],
				['mailerModLevelAdmin', 'mailerModLevelModerator'],
				['mailerModLevelAdmin', '/mailer/setting/update'],
				['mailerModLevelAdmin', '/mailer/setting/delete'],
				['mailerModLevelModerator', '/mailer/setting/index'],
				['mailerModLevelModerator', '/mailer/template/admin/*'],
				['mailerModLevelModerator', '/mailer/template/history/*'],
			]);
		}
	}
}
