<?php
/**
 * m191116_143100_mailer_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 16 November 2019, 14:31 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m191116_143100_mailer_module_insert_role extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

	public function up()
	{
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;

		$tableName = Yii::$app->db->tablePrefix . $authManager->itemTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'type', 'data', 'created_at'], [
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

		$tableName = Yii::$app->db->tablePrefix . $authManager->itemChildTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['parent', 'child'], [
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
