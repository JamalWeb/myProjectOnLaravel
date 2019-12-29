<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191126_082701_create_table_event
 */
class m191126_082701_create_table_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableRegistry::NAME_EVENT, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор события'),

            AttrRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя который создал событие'),

            AttrRegistry::TYPE_ID => $this->integer()
                ->notNull()
                ->comment('Тип события'),

            AttrRegistry::STATUS_ID => $this->integer()
                ->notNull()
                ->comment('Статус события'),

            AttrRegistry::NAME => $this->string(20)
                ->notNull()
                ->comment('Наименование'),

            AttrRegistry::ABOUT => $this->string(60)
                ->notNull()
                ->comment('Описание'),

            AttrRegistry::INTEREST_CATEGORY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор категории интереса'),

            AttrRegistry::CITY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор города'),

            AttrRegistry::ADDRESS => $this->string()
                ->notNull()
                ->comment('Адрес где будет происходить'),

            AttrRegistry::AGE_LIMIT => $this->integer()
                ->notNull()
                ->comment('Возростное ограничение'),

            AttrRegistry::TICKET_PRICE => $this->decimal(10, 2)
                ->comment('Цена за один билет'),

            AttrRegistry::TICKETS_NUMBER => $this->integer()
                ->comment('Кол-во доступных билетов'),

            AttrRegistry::ADDITIONAL_INFORMATION => $this->string(200)
                ->comment('Дополнительная информация'),

            AttrRegistry::IS_FREE => $this->boolean()
                ->defaultValue(false)
                ->comment('Флаг бесплатно или нет (если да то цена не учитывается)'),

            AttrRegistry::WALLPAPER => $this->string()
                ->notNull()
                ->comment('Фоновое изображение'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-user_id-event',
            TableRegistry::NAME_EVENT,
            AttrRegistry::USER_ID,
            TableRegistry::NAME_USER,
            AttrRegistry::ID
        );

        $this->addForeignKey(
            'FGK-type_id-event',
            TableRegistry::NAME_EVENT,
            AttrRegistry::TYPE_ID,
            TableRegistry::NAME_EVENT_TYPE,
            AttrRegistry::ID
        );

        $this->addForeignKey(
            'FGK-interest_category_id-event',
            TableRegistry::NAME_EVENT,
            AttrRegistry::INTEREST_CATEGORY_ID,
            TableRegistry::NAME_INTEREST_CATEGORY,
            AttrRegistry::ID
        );

        $this->addForeignKey(
            'FGK-city_id-event',
            TableRegistry::NAME_EVENT,
            AttrRegistry::CITY_ID,
            TableRegistry::NAME_CITY,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-city_id-event', TableRegistry::NAME_EVENT);
        $this->dropForeignKey('FGK-user_id-event', TableRegistry::NAME_EVENT);
        $this->dropForeignKey('FGK-type_id-event', TableRegistry::NAME_EVENT);
        $this->dropForeignKey('FGK-interest_category_id-event', TableRegistry::NAME_EVENT);
        $this->dropTable(TableRegistry::NAME_EVENT);
    }
}
