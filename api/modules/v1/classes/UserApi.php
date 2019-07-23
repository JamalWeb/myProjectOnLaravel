<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\ValidationException;
use api\modules\v1\models\form\UserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\components\StringHelper;
use common\models\user\Children;
use common\models\user\Role;
use common\models\user\User;
use common\models\user\UserType;
use Exception;
use Yii;
use yii\db\Transaction;

class UserApi extends Api
{
    /**
     * Регистрация нового пользователя
     *
     * @param array $params - Параметры пользователя
     * @return array
     * @throws ValidationException
     * @throws Exception
     */
    public final function registrationUser(array $params)
    {
        /**
         * Форма для создания пользователя
         *
         * @var UserForm $userForm
         */
        $userForm = new UserForm($params);

        /**
         * Валидация формы
         */
        if (!$userForm->validate()) {
            throw new ValidationException($userForm->getFirstErrors());
        }

        /**
         * Транзакция
         *
         * @var Transaction $transaction
         */
        $transaction = Yii::$app->db->beginTransaction();
        try {
            /**
             * Объект пользователя
             *
             * @var User $user
             */
            $user = new User();

            /**
             * Заполняем объект пользователя
             */
            $user->setAttributes([
                'email'        => $userForm->email,
                'role_id'      => Role::ROLE_USER,
                'user_type_id' => UserType::TYPE_USER,
                'password'     => $userForm->password
            ]);

            /**
             * Сохраняем объект пользователя
             */
            $user->saveModel();

            /**
             * Добавляем список детей пользователю
             */
            $this->childAdd($user, $userForm->children);

            /**
             * Отправляем письмо для подтверждения регистрации
             */
            EmailSendler::registrationConfirm($user);
            /**
             * Применяем транзакцию
             */
            $transaction->commit();

            return [
                'success' => true,
                'message' => 'Проверьте почту'
            ];
        } catch (Exception $e) {
            /**
             * Откатываем транзакцию
             */
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Добавляем детей пользователю
     *
     * @param User         $user         - Пользователь
     * @param string|array $childrenList - Список детей в формате JSON
     * @throws Exception
     */
    public final function childAdd(User $user, $childrenList): void
    {
        /**
         * Если список детей не пустой, то добавляем их пользователю
         */
        if (!empty($childrenList)) {
            if (is_string($childrenList)) {
                /**
                 * Список детей
                 *
                 * @var array $childList
                 */
                $childrenList = ArrayHelper::jsonToArray($childrenList);
            }

            /**
             * Транзакция
             *
             * @var Transaction $transaction
             */
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach (ArrayHelper::generator($childrenList) as $children) {
                    /**
                     * Проверка обязательных полей
                     */
                    $this->validateRequest($children, ['age', 'gender']);

                    /**
                     * @var array  $children       - Список данных ребенка
                     * @var int    $childrenAge    - Возраст ребенка
                     * @var string $childrenGender - Пол ребенка
                     */
                    list('age' => $childrenAge, 'gender' => $childrenGender) = $children;

                    /**
                     * Объект нового ребенка
                     *
                     * @var Children $children
                     */
                    $children = new Children([
                        'user_id' => $user->id,
                        'age'     => $childrenAge,
                        'gender'  => StringHelper::formatGender($childrenGender)

                    ]);

                    /**
                     * Сохраняем объект
                     */
                    $children->saveModel();
                }
                /**
                 * Применяем транзакцию
                 */
                $transaction->commit();
            } catch (Exception $e) {
                /**
                 * Откатываем транзакцию
                 */
                $transaction->rollBack();
                throw $e;
            }
        }
    }

    /**
     * Регистрация нового бизнеса
     */
    public function registrationBusiness()
    {
    }
}
