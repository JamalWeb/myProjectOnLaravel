<?php

namespace common\traits;

use yii\web\Controller;

trait RegisterMetaTag
{
    /**
     * @param string $title
     * @param string $keywords
     * @param string $description
     */
    public function registerMeta(string $title, string $keywords, string $description): void
    {
        /** @var  Controller $this */
        $controller = $this;

        $controller->view->title = $title;
        $controller->view->registerMetaTag(
            [
                'name' => 'description',
                'content' => $description,
            ],
            'description'
        );

        $controller->view->registerMetaTag(
            [
                'name' => 'keywords',
                'content' => $keywords,
            ],
            'keywords'
        );
    }
}
