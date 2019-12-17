<?php

use common\components\registry\AttributeRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_EVENT, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор события'),

            AttributeRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя который создал событие'),

            AttributeRegistry::TYPE_ID => $this->integer()
                ->notNull()
                ->comment('Тип события'),

            AttributeRegistry::STATUS_ID => $this->integer()
                ->notNull()
                ->comment('Статус события'),

            AttributeRegistry::NAME => $this->string(20)
                ->notNull()
                ->comment('Наименование'),

            AttributeRegistry::ABOUT => $this->string(60)
                ->notNull()
                ->comment('Описание'),

            AttributeRegistry::INTEREST_CATEGORY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор категории интереса'),

            AttributeRegistry::CITY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор города'),

            AttributeRegistry::ADDRESS => $this->string()
                ->notNull()
                ->comment('Адрес где будет происходить'),

            AttributeRegistry::AGE_LIMIT => $this->integer()
                ->notNull()
                ->comment('Возростное ограничение'),

            AttributeRegistry::TICKET_PRICE => $this->decimal(10, 2)
                ->comment('Цена за один билет'),

            AttributeRegistry::TICKETS_NUMBER => $this->integer()
                ->comment('Кол-во доступных билетов'),

            AttributeRegistry::ADDITIONAL_INFORMATION => $this->string(200)
                ->comment('Дополнительная информация'),

            AttributeRegistry::IS_FREE => $this->boolean()
                ->defaultValue(false)
                ->comment('Флаг бесплатно или нет (если да то цена не учитывается)'),

            AttributeRegistry::WALLPAPER => $this->string()
                ->notNull()
                ->comment('Фоновое изображение'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-user_id-event',
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::USER_ID,
            TableRegistry::TABLE_NAME_USER,
            AttributeRegistry::ID
        );

        $this->addForeignKey(
            'FGK-type_id-event',
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::TYPE_ID,
            TableRegistry::TABLE_NAME_EVENT_TYPE,
            AttributeRegistry::ID
        );

        $this->addForeignKey(
            'FGK-interest_category_id-event',
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::INTEREST_CATEGORY_ID,
            TableRegistry::TABLE_NAME_INTEREST_CATEGORY,
            AttributeRegistry::ID
        );

        $this->addForeignKey(
            'FGK-city_id-event',
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::CITY_ID,
            TableRegistry::TABLE_NAME_CITY,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-city_id-event', TableRegistry::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-user_id-event', TableRegistry::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-type_id-event', TableRegistry::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-interest_category_id-event', TableRegistry::TABLE_NAME_EVENT);
        $this->dropTable(TableRegistry::TABLE_NAME_EVENT);
    }
}
