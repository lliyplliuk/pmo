<?php

namespace app\widgets\NavMenu;

use dektrium\user\models\Profile;
use kartik\nav\NavX;
use Yii;
use Yii\helpers\Url;

class NavMenu extends NavX
{
    private array $menuArr;
    private array $roles;
    private string $username;

    public function init()
    {
        parent::init();
        $this->menuArr = require __DIR__ . '/../../config/menu.php';
    }

    public function run()
    {
        $this->getMenu();
        return parent::run();
    }

    private function getMenu()
    {
        $menuArr = [];
        $roles = [];
        foreach ($this->menuArr as $menuI => $v) {
            if (is_array($v['subitems'])) {
                foreach ($v['subitems'] as $subitems_v) {
                    if (isset($subitems_v['role']))
                        if (is_array($subitems_v['role'])) {
                            foreach ($subitems_v['role'] as $role_i => $role_name) {
                                $roles[$role_name] = false;
                                if (!in_array($role_name, $menuArr[$menuI] ?? []))
                                    $menuArr[$menuI][] = $role_name;
                            }
                        } else {
                            $roles[$subitems_v['role']] = false;
                            if (!in_array($subitems_v['role'], $menuArr[$menuI] ?? []))
                                $menuArr[$menuI][] = $subitems_v['role'];
                        }
                    if (isset($subitems_v['subitems']))
                        if (is_array($subitems_v['subitems'])) {
                            foreach ($subitems_v['subitems'] as $subitems2_i => $subitems2_v) {
                                if (is_array($subitems2_v['role'])) {
                                    foreach ($subitems2_v['role'] as $role_i => $role_name) {
                                        $roles[$role_name] = false;
                                        if (!in_array($role_name, $menuArr[$menuI] ?? []))
                                            $menuArr[$menuI][] = $role_name;
                                    }
                                } else {
                                    $roles[$subitems2_v['role']] = false;
                                    if (!in_array($subitems2_v['role'], $menuArr[$menuI] ?? []))
                                        $menuArr[$menuI][] = $subitems2_v['role'];
                                }
                            }
                        }
                }
            }
        }
        $roles['*'] = true;
        $this->roles = $roles;
        if (!Yii::$app->user->isGuest) {
            $this->username = (empty(Profile::findone(Yii::$app->user->identity->id)->name)) ? Yii::$app->user->identity->username : Profile::findone(Yii::$app->user->identity->id)->name;
            $this->menuArr[] = ['item' => "$this->username",
                'access' => true,
                'role' => '*',
                'subitems' => [
                    ['name' => 'Изменить профиль',
                        'url' => ['/user/settings'],
                        'role' => '*'
                    ],
                    ['name' => 'Выход (' . $this->username . ')',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                        'role' => '*'
                    ],
                ]
            ];
            foreach ($this->roles as $roleName => $roleVal) {
                $this->roles[$roleName] = Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, $roleName) || $roleVal;
            }
        }
        $this->items = [];
        foreach ($this->menuArr as $menuI => $v) {
            if (!isset($v['access'])) {
                $visible = $this->checkAccess($menuArr[$menuI]);
            } else {
                $visible = $v['access'];
            }
            if ($visible) {
                $this->items[] = $this->buildArrMenu($v);
            }
        }
    }

    private function buildArrMenu(array $arr): array
    {
        $thisUrl = urldecode(str_replace("/index", "", Url::current([], false)));
        $tmp = explode("?sort", $thisUrl);
        $thisUrl = $tmp[0];
        $tmp = explode("&sort", $thisUrl);
        $thisUrl = $tmp[0];
        $ret = [];
        $ret['label'] = $arr['item'];
        if (isset($arr['subitems'])) {
            $subItem = [];
            foreach ($arr['subitems'] as $iSub => $subItemArr)
                if ($this->checkAccess($subItemArr['role'] ?? '') || isset($subItemArr['subitems'])) {
                    $subItem[$iSub]['label'] = $subItemArr['name'];
                    $subItem[$iSub]['url'] = $subItemArr['url'] ?? '';
                    $subItem[$iSub]['linkOptions'] = $subItemArr['linkOptions'] ?? [];
                    if ($subItem[$iSub]['url'] === $thisUrl) {
                        $subItem[$iSub]['linkOptions']["class"] = "active";
                        $ret["active"] = true;
                    }
                    if (isset($subItemArr['subitems'])) {
                        $subItem2 = [];
                        foreach ($subItemArr['subitems'] as $iSub2 => $subItemArr2)
                            if ($this->checkAccess($subItemArr2['role'])) {
                                $subItem2[$iSub2]['label'] = $subItemArr2['name'];
                                $subItem2[$iSub2]['url'] = $subItemArr2['url'] ?? '';
                                $subItem2[$iSub2]['linkOptions'] = $subItemArr2['linkOptions'] ?? [];
                                if ($subItem2[$iSub2]['url'] === $thisUrl) {
                                    $subItem2[$iSub2]['linkOptions']["class"] = "active";
                                    $subItem[$iSub]['linkOptions']["class"] = "active";
                                    $ret["active"] = true;
                                }
                            }
                        $subItem[$iSub]['items'] = $subItem2;
                    }
                }
            $ret['items'] = $subItem;
        }
        return $ret;
    }

    public function checkAccess($role): bool
    {
        $ret = false;
        if (is_array($role)) {
            foreach ($role as $r)
                $ret = $ret || ($this->roles[$r] ?? false);
        } else {
            $ret = ($this->roles[$role] ?? false);
        }
        return $ret;
    }

}