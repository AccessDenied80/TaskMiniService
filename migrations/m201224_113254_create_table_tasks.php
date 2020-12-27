<?php

use yii\db\Migration;

/**
 * Class m201224_113254_create_table_tasks
 */
class m201224_113254_create_table_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey()->unsigned(),
            'created_at' => $this->integer(11)->unsigned()->notNull(),
            'is_finished' => $this->boolean()->unsigned()->defaultValue(false),
            //'user_id' => $this->integer(11)->unsigned()->->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-tasks-title}}',
            '{{%tasks}}',
            'title'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');
    }

}
