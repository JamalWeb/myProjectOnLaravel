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
use yii\db\Expression;
use yii\db\Query;
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
     * Список интересов
     *
     * @param User $user
     * @return Interest[]
     * @throws InvalidConfigException
     */
    public function getInterestUser(User $user): array
    {
        /** @var Interest[] $interests */
        $interests = (new Query())
            ->from(['i' => Interest::tableName()])
            ->select([
                'id'       => 'i.id',
                'name'     => 'i.name',
                'img'      => 'i.img',
                'selected' => new Expression('CASE WHEN "rui"."id" IS NOT NULL THEN true ELSE false END')
            ])
            ->leftJoin([
                'rui' => RelationUserInterest::tableName()
            ], 'i.id = rui.interest_id AND rui.user_id = :user_id', [
                ':user_id' => $user->id
            ])
            ->all();

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
     * Записать интересы пользователя
     *
     * @param User  $user
     * @param array $post
     * @return array
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function setInterestUser(User $user, array $post): array
    {
        ArrayHelper::validateRequestParams($post, ['interest_ids']);
        $interestIds = ArrayHelper::jsonToArray($post['interest_ids']);

        if (empty($interestIds)) {
            throw new BadRequestHttpException(['interest_ids' => 'Empty']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
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
            $transaction->commit();

            return $this->getInterestUser($user);
        } catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }
}
