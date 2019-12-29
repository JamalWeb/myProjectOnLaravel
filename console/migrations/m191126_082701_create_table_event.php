<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_EVENT,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор события'),

                RgAttribute::USER_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор пользователя который создал событие'),

                RgAttribute::TYPE_ID => $this->integer()
                    ->notNull()
                    ->comment('Тип события'),

                RgAttribute::STATUS_ID => $this->integer()
                    ->notNull()
                    ->comment('Статус события'),

                RgAttribute::NAME => $this->string(20)
                    ->notNull()
                    ->comment('Наименование'),

                RgAttribute::ABOUT => $this->string(60)
                    ->notNull()
                    ->comment('Описание'),

                RgAttribute::INTEREST_CATEGORY_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор категории интереса'),

                RgAttribute::CITY_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор города'),

                RgAttribute::ADDRESS => $this->string()
                    ->notNull()
                    ->comment('Адрес где будет происходить'),

                RgAttribute::AGE_LIMIT => $this->integer()
                    ->notNull()
                    ->comment('Возростное ограничение'),

                RgAttribute::TICKET_PRICE => $this->decimal(10, 2)
                    ->comment('Цена за один билет'),

                RgAttribute::TICKETS_NUMBER => $this->integer()
                    ->comment('Кол-во доступных билетов'),

                RgAttribute::ADDITIONAL_INFORMATION => $this->string(200)
                    ->comment('Дополнительная информация'),

                RgAttribute::IS_FREE => $this->boolean()
                    ->defaultValue(false)
                    ->comment('Флаг бесплатно или нет (если да то цена не учитывается)'),

                RgAttribute::WALLPAPER => $this->string()
                    ->notNull()
                    ->comment('Фоновое изображение'),

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
        $this->dropTable(RgTable::NAME_EVENT);
    }
}
