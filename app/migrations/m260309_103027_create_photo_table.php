<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photo}}`.
 */
class m260309_103027_create_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
        ]);

         // creates index for column `album_id`
        $this->createIndex(
            'idx-photo-album_id',
            'photo',
            'album_id'
        );

        // add foreign key for table `album`
        $this->addForeignKey(
            'fk-photo-album_id',
            'photo',
            'album_id',
            'album',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%photo}}');
    }
}
