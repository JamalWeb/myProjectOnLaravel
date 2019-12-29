<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_EVENT_PHOTO_GALLERY,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор фотографии'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование фотографии'),

                RgAttribute::EVENT_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор события'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->comment('Дата обновления')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_EVENT_PHOTO_GALLERY);
    }
}
