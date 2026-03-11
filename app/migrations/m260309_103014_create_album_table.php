<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%album}}`.
 */
class m260309_103014_create_album_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%album}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ]);

        // creates index for column `user_id`d
        $this->createIndex(
            'idx-album-user_id',
            'album',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-album-user_id',
            'album',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%album}}');
    }
}
