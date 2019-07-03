<?php

\api\swagger\MySwaggerAssetsV2::register($this);
/** @var string $rest_url */
/** @var array $oauthConfig */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vorchami Project-name Api Documentation</title>
    <?php $this->head() ?>
    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "<?= $rest_url ?>";
            }

            hljs.configure({
                highlightSizeThreshold: 5000
            });

            if (window.SwaggerTranslator) {
                window.SwaggerTranslator.translate();
            }
            window.swaggerUi = new SwaggerUi({
                url: url,
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['post', 'get'],
                onComplete: function (swaggerApi, swaggerUi) {
                    if (typeof initOAuth == "function") {
                        initOAuth(<?= json_encode($oauthConfig) ?>);
                    }

                    if (window.SwaggerTranslator) {
                        window.SwaggerTranslator.translate();
                    }
                },
                onFailure: function (data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "stop",
                jsonEditor: false,
                defaultModelRendering: 'schema',
                showRequestHeaders: true,
                showOperationIds: false
            });

            window.swaggerUi.load();

            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }

            $('#clear_cache').click(function () {
                $('#message-bar').html('Сбрасываем...');
                $('#swagger-ui-container').html('');
                $.get('/site/api', {'clear-cache': 1}, function () {
                    $('#message-bar').html('Проверяем валидность API...');
                    $.get('/site/api', function (data) {
                        if (data.error) {
                            $('#message-bar').html('Ошибка в описании документации:');
                            $('#swagger-ui-container').html('<b style="color:red">' + data.error + '</b>');
                        } else {
                            window.swaggerUi.load();
                            $('#message-bar').html('Строим доку... Ждем...');
                        }
                    });
                });
            });

            $('#collapse_hide').click(function () {
                window.swaggerUi.collapseAll();
            });

            $('#collapse_show').click(function () {
                window.swaggerUi.listAll();
            });

            $('.set_token').click(function () {
                var t = prompt('Введите токен:');
                if (t) {
                    $.get('/site/set-token', {t: t}, function () {
                        $('.no_auth').hide();
                        $('.auth_token').show();
                    });
                } else {
                    $.get('/site/set-token', {t: t}, function () {
                        $('.no_auth').show();
                        $('.auth_token').hide();
                    });
                    alert('Будет использоваться токен из доки');
                }
            });

            $('#get_token').click(function () {
                $.get('/site/get-token', function (data) {
                    console.log(data);
                });
            });

            $('#clear_token').click(function () {
                $.get('/site/set-token', {t: null}, function (data) {
                    $('.no_auth').show();
                    $('.auth_token').hide();
                });
            });

        });
    </script>
    <style>
        .panel {
            position: fixed;
            left: 10px;
            top: 60px;
        }

        .panel button {
            display: block;
            width: 188px;
            padding: 5px;
        }

        .no_auth, .auth_token {
            display: block;
        }

        <?php if(isset($_COOKIE['my_token'])):?>
        .no_auth {
            display: none;
        }

        <?php else:?>
        .auth_token {
            display: none;
        }

        <?php endif;?>
    </style>
</head>

<body class="swagger-section">
<?php $this->beginBody() ?>

<div id='header'>
    <div class="swagger-ui-wrap">
        <a id="logo" href="#"><span class="logo__title">Vorchami Project-name Api Documentation</span></a>
    </div>
    <div class="panel">
        <label>Документация</label>
        <button id="clear_cache">Перезагрузить</button>
        <button id="collapse_show">Развернуть</button>
        <button id="collapse_hide">Свернуть</button>
        <label>Авторизация</label>
        <div class="no_auth">
            <button class="set_token">Установить токен</button>
        </div>
        <div class="auth_token">
            <button class="set_token">Сменить токен</button>
            <button id="get_token">Вывести токен в консоль</button>
            <button id="clear_token">Сбросить токен</button>
        </div>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
