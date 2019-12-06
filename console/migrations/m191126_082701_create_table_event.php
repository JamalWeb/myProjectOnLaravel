<?php

use yii\db\Migration;

/**
 * Class m191126_082701_create_table_event
 */
class m191126_082701_create_table_event extends Migration
{
    const TABLE_NAME_EVENT = '{{%event}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME_EVENT, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор события'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя который создал событие'),

            'type_id' => $this->integer()
                ->notNull()
                ->comment('Тип события'),

            'name' => $this->string(20)
                ->notNull()
                ->comment('Наименование'),

            'about' => $this->string(60)
                ->notNull()
                ->comment('Описание'),

            'interest_category_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор категории интереса'),

            'city_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор города'),

            'address' => $this->string()
                ->notNull()
                ->comment('Адрес где будет происходить'),

            'age_limit' => $this->integer()
                ->notNull()
                ->comment('Возростное ограничение'),

            'ticket_price' => $this->decimal(10, 2)
                ->comment('Цена за один билет'),

            'number_tickets' => $this->integer()
                ->comment('Доступные билеты'),

            'additional_information' => $this->string(200)
                ->comment('Дополнительная информация'),

            'is_free' => $this->boolean()
                ->defaultValue(false)
                ->comment('Флаг бесплатно или нет (если да то цена не учитывается)'),

            'wallpaper' => $this->string()
                ->notNull()
                ->comment('Фоновое изображение'),

            'created_at' => $this->timestamp()
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-user_id-event',
            self::TABLE_NAME_EVENT,
            'user_id',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey(
            'FGK-type_id-event',
            self::TABLE_NAME_EVENT,
            'type_id',
            '{{%event_type}}',
            'id'
        );

        $this->addForeignKey(
            'FGK-interest_category_id-event',
            self::TABLE_NAME_EVENT,
            'interest_category_id',
            '{{%interest_category}}',
            'id'
        );

        $this->addForeignKey(
            'FGK-city_id-event',
            self::TABLE_NAME_EVENT,
            'city_id',
            '{{%city}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-city_id-event', self::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-user_id-event', self::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-type_id-event', self::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-interest_category_id-event', self::TABLE_NAME_EVENT);
        $this->dropTable(self::TABLE_NAME_EVENT);
    }
}
