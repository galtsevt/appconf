# Пользваотельсике настроки приложения laravel

Призван упростить добавление новых настроек в админ панель. 

## Установка
```composer require galtsevt/appconf```
## Использование
Создать файлы конфигурации в app/settings/factory по примеру, один файл = один таб.
Глобальный хелпер для получения значения по ключу ```settings('key', 'DefaultValue')```
## Добавить middleware в конфиг
/config/admin_settings.php

```<?php
return [
'middleware' => ['web', 'auth'],
'extends_layout' => 'admin.layouts.app',
]
```

