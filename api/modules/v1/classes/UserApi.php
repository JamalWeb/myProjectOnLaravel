<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\ValidationException;
use api\modules\v1\models\form\UserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\components\StringHelper;
use common\models\user\Children;
use common\models\user\Gender;
use common\models\user\Role;
use common\models\user\User;
use common\models\user\UserType;
use Exception;
use Yii;
use yii\db\Transaction;

class UserApi extends Api
{
    /**
     * @return array
     */
    public final function getGender(): array
    {
        $genders = Gender::find()->all();

        return $genders;
    }

    /**
     * Регистрация обычного пользователя
     *
     * @param array $params - Параметры пользователя
     * @return array
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
             * Подготовка данных для регистрации
             *
             * @var array $params
             */
            $params = $user->prepareRegistration([
                'email'        => $userForm->email,
                'password'     => $userForm->password,
                'role_id'      => Role::ROLE_USER,
                'user_type_id' => UserType::TYPE_USER,
            ]);

            /**
             * Заполняем объект пользователя
             */
            $user->setAttributes($params);

            /**
             * Валидация и сохранение объекта
             */
            $user->saveModel();

            /**
             * Создание профиля для пользователя
             */
            $this->createProfile($user, [
                'city_id' => $userForm->city_id,
                'name'    => $userForm->name
            ]);

            /**
             * Список детей
             *
             * @var array $childList
             */
            $childrenList = !empty($userForm->children) ? ArrayHelper::jsonToArray($userForm->children) : [];

            /**
             * Добавляем список детей пользователю
             */
            $this->childAdd($user, $childrenList);

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
     * Регистрация нового бизнеса
     */
    public function registrationBusiness()
    {
    }

    private function createProfile(User $user, array $params)
    {
    }

    /**
     * Добавляем детей пользователю
     *
     * @param User  $user         - Пользователь
     * @param array $childrenList - Список детей
     * @throws Exception
     */
    public final function childAdd(User $user, array $childrenList): void
    {
        /**
         * Если список детей не пустой, то добавляем их пользователю
         */
        if (!empty($childrenList)) {

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
                     * @var array  $children - Список данных ребенка
                     * @var int    $age      - Возраст ребенка
                     * @var string $gender   - Пол ребенка
                     */
                    list('age' => $age, 'gender' => $gender) = $children;

                    /**
                     * Форматируес строку пол ребенка
                     *
                     * @var string $gender
                     */
                    $gender = StringHelper::formatGender($gender);

                    /**
                     * Объект нового ребенка
                     *
                     * @var Children $children
                     */
                    $children = new Children([
                        'user_id' => $user->id,
                        'age'     => $age,
                        'gender'  => $gender
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
}
