<?php

use common\components\registry\Constants;
use yii\db\Migration;

/**
 * Class m191206_134806_create_table_event_photo_gallery
 */
class m191206_134806_create_table_event_photo_gallery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Constants::TABLE_NAME_EVENT_PHOTO_GALLERY, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор фотографии'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование фотографии'),

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
            Constants::TABLE_NAME_EVENT_PHOTO_GALLERY,
            'event_id',
            Constants::TABLE_NAME_EVENT,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_photo_gallery', Constants::TABLE_NAME_EVENT_PHOTO_GALLERY);
        $this->dropTable(Constants::TABLE_NAME_EVENT_PHOTO_GALLERY);
    }
}
