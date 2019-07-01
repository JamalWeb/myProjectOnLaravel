<?php

\api_web\components\MySwggerAssets::register($this);
/** @var string $rest_url */
/** @var array $oauthConfig */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MixCart Api Web Documentation</title>
    <?php $this->head() ?>
    <script type="text/javascript">


        window.onload = function () {

            function load() {
                // Begin Swagger UI call region
                return SwaggerUIBundle({
                    url: "<?= $rest_url ?>",
                    dom_id: '#swagger-ui-container',
                    deepLinking: true,
                    presets: [
                        SwaggerUIBundle.presets.apis,
                        SwaggerUIStandalonePreset
                    ],
                    layout: "BaseLayout"
                });
            }

            window.ui = load();

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
                            $('#message-bar').html('Строим доку... Ждем...');
                            window.ui = load();
                        }
                    });
                });
            });
        }
    </script>
    <style>
        #message-bar {
            text-align: center;
        }
    </style>
</head>

<body class="swagger-section">
<?php $this->beginBody() ?>
<div id='header'>
    <div style="position:fixed;left:10px;top:10px">
        <button id="clear_cache">Reload cache</button>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
