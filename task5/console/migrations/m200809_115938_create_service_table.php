<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 */
class m200809_115938_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'code' => $this->string(20)->notNull(),
            'price' => $this->float()->notNull(),
            'description' => $this->text(),
            'status' => $this->boolean()->notNull(),
            'due_to' => $this->dateTime()->notNull(),
            'city' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'service_user_fk',
            '{{%service}}',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('service_user_fk', '{{%service}}');
        $this->dropTable('{{%service}}');
    }
}
