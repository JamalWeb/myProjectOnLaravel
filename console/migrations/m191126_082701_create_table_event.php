<?php

use yii\db\Migration;

/**
 * Class m191126_082701_create_table_event
 */
class m191126_082701_create_table_event extends Migration
{
    const TABLE_NAME_EVENT = '{{%event}}';
    const TABLE_NAME_EVENT_TYPE = '{{%event_type}}';

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

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование события'),

            'about' => $this->string()
                ->notNull()
                ->comment('Описание события'),

            'age_limit' => $this->integer()
                ->notNull()
                ->comment('Возростное ограничение'),

            'address' => $this->string()
                ->notNull()
                ->comment('Адрес где будет происходить событие'),

            'interest_category_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор категории интереса события'),

            'ticket_price' => $this->decimal(10, 2)
                ->comment('Цена за один билет'),

            'is_free' => $this->boolean()
                ->defaultValue(false)
                ->comment('Флаг событие беслатное или нет'),

            'wallpaper' => $this->string()
                ->notNull()
                ->comment('Изображение события'),

        ]);

        $this->addForeignKey(
            'FGK-user_id-event',
            self::TABLE_NAME_EVENT,
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'FGK-type_id-event',
            self::TABLE_NAME_EVENT,
            'type_id',
            self::TABLE_NAME_EVENT_TYPE,
            'id'
        );

        $this->addForeignKey(
            'FGK-interest_category_id-event',
            self::TABLE_NAME_EVENT,
            'interest_category_id',
            'interest_category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-user_id-event', self::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-type_id-event', self::TABLE_NAME_EVENT);
        $this->dropForeignKey('FGK-interest_category_id-event', self::TABLE_NAME_EVENT);
        $this->dropTable(self::TABLE_NAME_EVENT);
    }
}
