<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\DateHelper;
use common\models\Interest;
use common\models\relations\RelationUserInterest;
use common\models\user\User;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\UrlManager;

class InterestApi extends Api
{
    /**
     * Список интересов
     *
     * @return Interest[]
     * @throws InvalidConfigException
     */
    public function get(): array
    {
        /** @var Interest[] $interests */
        $interests = Interest::find()->all();

        /** @var UrlManager $urlManagerFront */
        $urlManagerFront = Yii::$app->get('urlManagerFront');

        /** @var string $interestPath */
        $interestPath = Yii::getAlias('@interestPath');

        foreach (ArrayHelper::generator($interests) as $interest) {
            $interest['img'] = "{$urlManagerFront->baseUrl}/$interestPath/{$interest['img']}";
        }

        return $interests;
    }

    /**
     * Изменить интересы пользователя
     *
     * @param User  $user
     * @param array $post
     * @return array
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function updateUserInterests(User $user, array $post): array
    {
        ArrayHelper::validateRequestParams($post, ['interest_ids']);
        $interestIds = ArrayHelper::jsonToArray($post['interest_ids']);

        if (empty($interestIds)) {
            throw new BadRequestHttpException(['interest_ids' => 'Empty']);
        }

        RelationUserInterest::deleteAll(['user_id' => $user->id]);

        $interests = [];
        foreach ($interestIds as $interestId) {
            $interests[] = [
                'user_id'     => $user->id,
                'interest_id' => $interestId,
                'created_at'  => DateHelper::getTimestamp(),
                'updated_at'  => DateHelper::getTimestamp()
            ];
        }

        Yii::$app->db->createCommand()
            ->batchInsert(RelationUserInterest::tableName(), [
                'user_id',
                'interest_id',
                'created_at',
                'updated_at'
            ], $interests)
            ->execute();

        return $this->get();
    }
}
