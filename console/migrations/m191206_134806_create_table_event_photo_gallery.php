<?php

use yii\db\Migration;

/**
 * Class m191206_134806_create_table_event_photo_gallery
 */
class m191206_134806_create_table_event_photo_gallery extends Migration
{
    const TABLE_NAME = '{{%event_photo_gallery}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор фотографии'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование картинки'),

            'event_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор события'),

            'created_at' => $this->timestamp()
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-event_id-event_photo_gallery',
            self::TABLE_NAME,
            'event_id',
            '{{%event}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_photo_gallery', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
