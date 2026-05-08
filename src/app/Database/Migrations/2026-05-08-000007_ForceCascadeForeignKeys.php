<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ForceCascadeForeignKeys extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('codes')) {
            $this->dropForeignKeyIfExists('codes', 'fk_codes_user');
            $this->dropForeignKeyIfExists('codes', 'fk_codes_user_cascade');
            $this->db->query('ALTER TABLE `codes` ADD CONSTRAINT `fk_codes_user_cascade` FOREIGN KEY (`used_by`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        }

        if ($this->db->tableExists('user_regimes')) {
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_user');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_regime');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_duree');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_activite');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_user_cascade');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_regime_cascade');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_duree_cascade');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_activite_cascade');

            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_user_cascade` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_regime_cascade` FOREIGN KEY (`regime_id`) REFERENCES `regimes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_duree_cascade` FOREIGN KEY (`regime_duree_id`) REFERENCES `regime_durees`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_activite_cascade` FOREIGN KEY (`activite_id`) REFERENCES `activites`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        }
    }

    public function down()
    {
        if ($this->db->tableExists('codes')) {
            $this->dropForeignKeyIfExists('codes', 'fk_codes_user');
            $this->dropForeignKeyIfExists('codes', 'fk_codes_user_cascade');
            $this->db->query('ALTER TABLE `codes` ADD CONSTRAINT `fk_codes_user` FOREIGN KEY (`used_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE');
        }

        if ($this->db->tableExists('user_regimes')) {
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_user');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_regime');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_duree');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_activite');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_user_cascade');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_regime_cascade');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_duree_cascade');
            $this->dropForeignKeyIfExists('user_regimes', 'fk_ur_activite_cascade');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_regime` FOREIGN KEY (`regime_id`) REFERENCES `regimes`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_duree` FOREIGN KEY (`regime_duree_id`) REFERENCES `regime_durees`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE');
            $this->db->query('ALTER TABLE `user_regimes` ADD CONSTRAINT `fk_ur_activite` FOREIGN KEY (`activite_id`) REFERENCES `activites`(`id`) ON DELETE SET NULL ON UPDATE CASCADE');
        }
    }

    private function dropForeignKeyIfExists(string $table, string $constraint): void
    {
        $builder = $this->db->table('information_schema.TABLE_CONSTRAINTS');
        $exists = $builder
            ->where('CONSTRAINT_SCHEMA', $this->db->getDatabase())
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->countAllResults();

        if ($exists) {
            $this->db->query(sprintf('ALTER TABLE `%s` DROP FOREIGN KEY `%s`', $table, $constraint));
        }
    }
}
