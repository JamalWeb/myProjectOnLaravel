<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_EVENT_PHOTO_GALLERY, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор фотографии'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование фотографии'),

            AttributeRegistry::EVENT_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор события'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-event_id-event_photo_gallery',
            TableRegistry::TABLE_NAME_EVENT_PHOTO_GALLERY,
            AttributeRegistry::EVENT_ID,
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_photo_gallery', TableRegistry::TABLE_NAME_EVENT_PHOTO_GALLERY);
        $this->dropTable(TableRegistry::TABLE_NAME_EVENT_PHOTO_GALLERY);
    }
}
