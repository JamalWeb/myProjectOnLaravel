<?php

namespace api\modules\versions\v1\controllers;

use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * @SWG\Post(path="/users",
     *     tags={"user"},
     *     summary="创建用户接口",
     *     description="测试Param是 *query* 类型, 如果设置成 *formData* 类型的就可以使用post获取数据",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "username",
     *        description = "用户姓名",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "phone",
     *        description = "手机号",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "sex",
     *        description = "性别 1. 男 2.女 此项为非必填项.展示成select",
     *        required = false,
     *        type = "integer",
     *        enum = {1, 2}
     *     ),
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = " success"
     *     ),
     *     @SWG\Response(
     *         response = 401,
     *         description = "需要重新登陆",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     */
    public function actionGet()
    {
        return Yii::getAlias('@api/modules/versions/v1/controllers');
    }
}
