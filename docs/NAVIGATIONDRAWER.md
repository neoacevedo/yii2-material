## Navigation Drawer

Navigation Drawer tiene 2 estados: estándar y modal. El primer estado lo hace visible en todo momento. El segundo estado lo hace visible al hacer clic en algún botón 
que lo haga visible.

Más info: https://m3.material.io/components/navigation-drawer/guidelines#159bffe1-2fea-4d47-9e50-e2cfa0ec37ef



```php
<?php
NavigationDrawer::widget([
    '' => [
    
    ],
    'items' => [
        [
            'leading-icon' => 'manage_accounts',
            'headline' => Yii::t('backend/admin', 'Admins'),
            'options' => [
                'type' => 'link',
                'href' => ['admin/index'],
                'class' => 'drawer-list-item'
            ]
        ],
    ]
]);
?>
```