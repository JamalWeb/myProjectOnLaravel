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

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование'),

                RgAttribute::ABOUT => $this->string()
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

                RgAttribute::MIN_AGE_CHILD => $this->integer()
                    ->notNull()
                    ->comment('Минимальный допустимый возраст ребенка'),

                RgAttribute::MAX_AGE_CHILD => $this->integer()
                    ->comment('Максимальный допустимый возраст ребенка'),

                RgAttribute::TICKET_PRICE => $this->decimal(10, 2)
                    ->comment('Цена за один билет'),

                RgAttribute::TICKETS_NUMBER => $this->integer()
                    ->comment('Кол-во доступных билетов'),

                RgAttribute::ADDITIONAL_INFORMATION => $this->string()
                    ->comment('Дополнительная информация'),

                RgAttribute::WALLPAPER => $this->string()
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
