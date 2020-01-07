<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\DateHelper;
use common\components\registry\RgAttribute;
use common\models\InterestCategory;
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
     * @return InterestCategory[]
     * @throws InvalidConfigException
     */
    public function getList(): array
    {
        /** @var InterestCategory[] $interests */
        $interests = InterestCategory::find()->all();

        /** @var UrlManager $urlManagerFront */
        $urlManagerFront = Yii::$app->get('urlManagerFront');

        /** @var string $interestPath */
        $interestPath = Yii::getAlias('@interestPath');

        foreach (ArrayHelper::generator($interests) as $interest) {
            $interest[RgAttribute::IMG] = "{$urlManagerFront->baseUrl}/$interestPath/{$interest[RgAttribute::IMG]}";
        }

        return $interests;
    }

    /**
     * Список интересов
     *
     * @param User $user
     * @return InterestCategory[]
     * @throws InvalidConfigException
     */
    public function getInterestUser(User $user): array
    {
        /** @var InterestCategory[] $interests */
        $interests = (new Query())
            ->from(['i' => InterestCategory::tableName()])
            ->select(
                [
                    RgAttribute::ID       => 'i.id',
                    RgAttribute::NAME     => 'i.name',
                    RgAttribute::IMG      => 'i.img',
                    RgAttribute::SELECTED => new Expression('CASE WHEN "rui"."id" IS NOT NULL THEN true ELSE false END')
                ]
            )
            ->leftJoin(
                [
                    'rui' => RelationUserInterest::tableName()
                ],
                'i.id = rui.interest_id AND rui.user_id = :user_id',
                [
                    ':user_id' => $user->id
                ]
            )
            ->all();

        /** @var UrlManager $urlManagerFront */
        $urlManagerFront = Yii::$app->get('urlManagerFront');

        /** @var string $interestPath */
        $interestPath = Yii::getAlias('@interestPath');

        foreach (ArrayHelper::generator($interests) as $interest) {
            $interest[RgAttribute::IMG] = "{$urlManagerFront->baseUrl}/$interestPath/{$interest[RgAttribute::IMG]}";
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
        ArrayHelper::validateParams($post, ['interest_ids']);
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
                    RgAttribute::USER_ID              => $user->id,
                    RgAttribute::INTEREST_CATEGORY_ID => $interestId,
                    RgAttribute::CREATED_AT           => DateHelper::getTimestamp(),
                    RgAttribute::UPDATED_AT           => DateHelper::getTimestamp()
                ];
            }

            Yii::$app->db->createCommand()
                ->batchInsert(
                    RelationUserInterest::tableName(),
                    [
                        RgAttribute::USER_ID,
                        RgAttribute::INTEREST_CATEGORY_ID,
                        RgAttribute::CREATED_AT,
                        RgAttribute::UPDATED_AT
                    ],
                    $interests
                )
                ->execute();
            $transaction->commit();

            return $this->getInterestUser($user);
        } catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }
}
