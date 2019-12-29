<?php

use common\components\registry\AttrRegistry;
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
        $this->createTable(TableRegistry::NAME_EVENT_PHOTO_GALLERY, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор фотографии'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование фотографии'),

            AttrRegistry::EVENT_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор события'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-event_id-event_photo_gallery',
            TableRegistry::NAME_EVENT_PHOTO_GALLERY,
            AttrRegistry::EVENT_ID,
            TableRegistry::NAME_EVENT,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_photo_gallery', TableRegistry::NAME_EVENT_PHOTO_GALLERY);
        $this->dropTable(TableRegistry::NAME_EVENT_PHOTO_GALLERY);
    }
}
