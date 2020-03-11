<?php

namespace console\components;

use common\models\translate\Message;
use common\models\translate\SourceMessage;
use Throwable;
use yii\db\StaleObjectException;

class TranslateHelper
{
    /**
     * @param array $data ['ru' => ['category' => ['common.generic.variable' => 'translation', ...]], 'en' => ...]
     */
    public static function insert($data): void
    {
        foreach ($data as $language => $categories) {
            self::insertLanguage($language, $categories);
        }
    }

    /**
     * @param string $language
     * @param array  $categories ['category' => ['common.generic.variable' => 'translation', ...]]
     */
    public static function insertLanguage($language, $categories): void
    {
        foreach ($categories as $category => $translations) {
            self::insertCategory($language, $category, $translations);
        }
    }

    /**
     * @param string $language
     * @param string $category
     * @param array  $translations ['common.generic.variable' => 'translation', ...]
     */
    public static function insertCategory($language, $category, $translations): void
    {
        foreach ($translations as $var => $translation) {
            $source_message = SourceMessage::findOne(['message' => $var, 'category' => $category]);

            if ($source_message === null) {
                $source_message = new SourceMessage();
                $source_message->message = $var;
                $source_message->category = $category;
                $source_message->save();
            }

            $message = Message::findOne(['id' => $source_message->id, 'language' => $language]);
            if ($message === null) {
                $message = new Message();
            }

            $message->id = $source_message->id;
            $message->language = $language;
            $message->translation = $translation;
            $message->save();
        }
    }

    /**
     * @param array $data ['ru' => ['category' => ['common.generic.variable' => 'translation', ...]], 'en' => ...]
     * @throws StaleObjectException
     * @throws Throwable
     */
    public static function delete($data): void
    {
        foreach ($data as $language => $categories) {
            self::deleteLanguage($language, $categories);
        }
    }

    /**
     * @param string $language
     * @param array  $categories ['category' => ['common.generic.variable' => 'translation', ...]]
     * @throws StaleObjectException
     * @throws Throwable
     */
    public static function deleteLanguage($language, $categories): void
    {
        foreach ($categories as $category => $translations) {
            self::deleteCategory($language, $category, $translations);
        }
    }

    /**
     * @param string $language
     * @param string $category
     * @param array  $translations ['common.generic.variable' => 'translation', ...]
     * @throws Throwable
     * @throws StaleObjectException
     */
    public static function deleteCategory($language, $category, $translations): void
    {
        foreach ($translations as $var => $translation) {
            $source_message = SourceMessage::findOne(['message' => $var, 'category' => $category]);
            if ($source_message !== null) {
                $message = Message::findOne(['id' => $source_message->id, 'language' => $language]);
                if ($message !== null) {
                    $message->delete();
                }
                $source_message->delete();
            }
        }
    }
}
