<?php
/**
 * m230604_173715_mailerModule_addTrigger_all
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2023 OMMU (www.ommu.id)
 * @created date 4 June 2023, 17:37 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use yii\db\Schema;

class m230604_173715_mailerModule_addTrigger_all extends \yii\db\Migration
{
	public function up()
	{
		// alter trigger mailerBeforeInsertMailTemplate
		$alterTriggerMailerBeforeInsertMailTemplate = <<< SQL
CREATE
    TRIGGER `mailerBeforeInsertMailTemplate` BEFORE INSERT ON `ommu_mailer_mail_template` 
    FOR EACH ROW BEGIN
	IF (NEW.type <> 'content') THEN
		SET NEW.header_footer = NULL;
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeInsertMailTemplate`');
		$this->execute($alterTriggerMailerBeforeInsertMailTemplate);

		// alter trigger mailerAfterInsertMailTemplate
		$alterTriggerMailerAfterInsertMailTemplate = <<< SQL
CREATE
    TRIGGER `mailerAfterInsertMailTemplate` AFTER INSERT ON `ommu_mailer_mail_template` 
    FOR EACH ROW BEGIN
	IF (NEW.template_file <> '') THEN
		INSERT `ommu_mailer_mail_template_history` (`template`, `header_footer`, `template_file`, `creation_date`, `creation_id`)
		VALUE (NEW.template, NEW.header_footer, NEW.template_file, NEW.creation_date, NEW.creation_id);
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `mailerAfterInsertMailTemplate`');
		$this->execute($alterTriggerMailerAfterInsertMailTemplate);

		// alter trigger mailerBeforeUpdateMailTemplate
		$alterTriggerMailerBeforeUpdateMailTemplate = <<< SQL
CREATE
    TRIGGER `mailerBeforeUpdateMailTemplate` BEFORE UPDATE ON `ommu_mailer_mail_template` 
    FOR EACH ROW BEGIN
	IF (NEW.type <> OLD.type AND NEW.type <> 'content') THEN
		SET NEW.header_footer = NULL;
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeUpdateMailTemplate`');
		$this->execute($alterTriggerMailerBeforeUpdateMailTemplate);

		// alter trigger mailerAfterUpdateMailTemplate
		$alterTriggerMailerAfterUpdateMailTemplate = <<< SQL
CREATE
    TRIGGER `mailerAfterUpdateMailTemplate` AFTER UPDATE ON `ommu_mailer_mail_template` 
    FOR EACH ROW BEGIN
	IF (NEW.template_file <> OLD.template_file) THEN
		INSERT `ommu_mailer_mail_template_history` (`template`, `header_footer`, `template_file`, `creation_date`, `creation_id`)
		VALUE (NEW.template, NEW.header_footer, NEW.template_file, NEW.modified_date, NEW.modified_id);
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `mailerAfterUpdateMailTemplate`');
		$this->execute($alterTriggerMailerAfterUpdateMailTemplate);

		// alter trigger mailerBeforeUpdateBlastingTarget
		$alterTriggerMailerBeforeUpdateBlastingTarget = <<< SQL
CREATE
    TRIGGER `mailerBeforeUpdateBlastingTarget` BEFORE UPDATE ON `ommu_mailer_blasting_target` 
    FOR EACH ROW BEGIN
	IF (NEW.status <> OLD.status) THEN
		SET NEW.updated_date = NOW();
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeUpdateBlastingTarget`');
		$this->execute($alterTriggerMailerBeforeUpdateBlastingTarget);

		// alter trigger mailerBeforeUpdateBlastingTargetNonMember
		$alterTriggerMailerBeforeUpdateBlastingTargetNonMember = <<< SQL
CREATE
    TRIGGER `mailerBeforeUpdateBlastingTargetNonMember` BEFORE UPDATE ON `ommu_mailer_blasting_target_non_member` 
    FOR EACH ROW BEGIN
	IF (NEW.status <> OLD.status) THEN
		SET NEW.updated_date = NOW();
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeUpdateBlastingTargetNonMember`');
		$this->execute($alterTriggerMailerBeforeUpdateBlastingTargetNonMember);
	}

	public function down()
	{
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeInsertMailTemplate`');
        $this->execute('DROP TRIGGER IF EXISTS `mailerAfterInsertMailTemplate`');
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeUpdateMailTemplate`');
        $this->execute('DROP TRIGGER IF EXISTS `mailerAfterUpdateMailTemplate`');
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeUpdateBlastingTarget`');
        $this->execute('DROP TRIGGER IF EXISTS `mailerBeforeUpdateBlastingTargetNonMember`');
	}
}
