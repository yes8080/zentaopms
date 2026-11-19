<?php
namespace zin;

require_once dirname(__DIR__) . DS . 'btn' . DS . 'v1.php';
require_once dirname(__DIR__) . DS . 'sidebar' . DS . 'v1.php';

class teammateMenu extends wg
{
    public static function getPageCSS(): ?string
    {
        return <<<'CSS'
        .module-menu {max-height: calc(100vh - 79px); display: flex; flex-direction: column; min-height: 32px; --menu-selected-bg: none;}
        .module-menu header a:hover > .icon {color: var(--color-primary-600) !important;}
        .module-menu .module-item * {white-space: nowrap;}
        .module-menu .module-item:hover,.module-menu .module-item.selected {background: var(--color-primary-50);}
        .has-module-menu-header #mainMenu {padding-left: 180px;}
        .module-menu-header.is-fixed {position: absolute; left: 0; top: -44px; width: 160px; height: 32px; border: 1px solid var(--color-border); justify-content: center; padding: 0 24px; border-right: 0;}
        .module-menu-header.is-fixed::before,
        .module-menu-header.is-fixed::after {content: ''; position: absolute; top: 0; right: -12px; width: 0; height: 0; border-style: solid; border-color: transparent transparent transparent var(--color-border); border-width: 15px 0 15px 12px;}
        .module-menu-header.is-fixed::after {right: -11px; border-color: transparent transparent transparent var(--color-canvas);}
        .has-module-menu-header.is-sidebar-left-collapsed .module-menu-header.is-fixed {left: var(--gutter-width)}
        .module-menu-header.is-fixed .module-title {font-size: var(--font-size-base);}
        .module-menu-header.is-fixed > .btn-close {position: absolute; right: 0; font-weight: normal;}
        .module-menu-header.is-fixed > .btn-close:not(:hover) {opacity: .5;}
        .sidebar > .module-menu-header.is-fixed {display: flex!important;}
        .sidebar-left > .module-menu {margin-right: -8px}
        .sidebar-left.is-expanded > .module-menu ~ .sidebar-gutter {margin-left: 4px}
        .sidebar-right.is-expanded > .module-menu ~ .sidebar-gutter {margin-right: 4px}
        .is-expanded > .module-menu ~ .sidebar-gutter > .gutter-toggle {opacity: 0}
        .has-module-menu-header .sidebar-left {transition-property: width;}
        .has-module-menu-header .module-menu {max-height: calc(100vh - 105px); }
        CSS;
    }

    private function buildMenuTree(): node|array
    {
        $modules = $this->prop('modules');
        $link    = $this->prop('link');
        if(count($modules) === 0) return [];

        global $app, $lang;
        $app->loadLang('user');
        $app->loadLang('aiteammate');
        $activeKey = $this->prop('activeKey');
        $treeItems = array();
        foreach($modules as $moduleItem)
        {
            $selected = $activeKey == $moduleItem->id;
            $role     = !empty($lang->user->roleList[$moduleItem->role]) ? $lang->user->roleList[$moduleItem->role] : $moduleItem->role;
            $avatar   = $moduleItem->avatar;
            $noAvatar = empty($avatar);
            if($noAvatar) $avatar = $app->config->webRoot . 'static/zentaoaipro/ai-teammate-default.png';
            if(strpos($avatar, $app->config->webRoot) !== 0) $avatar = $app->config->webRoot . $avatar;
            $treeItems[] = h::a
            (
                set::href(sprintf($link, $moduleItem->id)),
                setClass('w-full py-2.5 px-3 flex items-center gap-2 mt-3 module-item', $selected ? 'selected' : ''),
                avatar
                (
                    setStyle(array('min-width' => '36px', 'filter' => $noAvatar ? 'hue-rotate(' . (($moduleItem->id * 53) % 360) . 'deg)' : '')),
                    set::src($avatar),
                    set::text($moduleItem->name),
                    set::size(36),
                ),
                div
                (
                    setClass('text-ellipsis'),
                    p
                    (
                        setClass('text-primary font-bold text-ellipsis'),
                        set::title($moduleItem->name),
                        span($moduleItem->name),
                        $moduleItem->disabled ? label(setClass('danger-pale text-danger text-sm font-normal ml-2'), $lang->aiteammate->disabled) : null
                    ),
                    p(setClass('text-fore text-ellipsis'), set::title($role), $role),
                )
            );
        }

        return div(setClass('scrollbar-thin scrollbar-hover overflow-auto px-2'), $treeItems);
    }

    private function getTitle(): string
    {
        if($this->prop('title')) return $this->prop('title');

        global $lang, $app;
        $activeKey = $this->prop('activeKey');

        if(empty($activeKey))
        {
            $allText = $this->prop('allText');
            if(empty($allText)) return $lang->all;
            return $allText;
        }

        $modules    = $this->prop('modules');
        $moduleName = '';
        if($modules) array_map(function($module) use(&$moduleName, $activeKey) {if($module->id == $activeKey) $moduleName = $module->name;}, $modules);

        return $moduleName;
    }

    private function buildCloseBtn(): node|null
    {
        $closeLink  = $this->prop('closeLink');
        $tab        = $this->prop('app');
        $titleAttrs = array();
        if($tab)        $titleAttrs['app']  = $tab;
        if(isInModal()) $titleAttrs['load'] = 'modal';
        if(!$closeLink) return null;

        $activeKey = $this->prop('activeKey');
        if(empty($activeKey)) return null;

        return btn
        (
            setClass('btn-close rounded-full'),
            set::icon('close'),
            set::url($closeLink),
            set::size('sm'),
            set::type('ghost'),
            $titleAttrs ? setData($titleAttrs) : null
        );
    }

    protected function build(): array
    {
        global $app;

        $title         = $this->getTitle();
        $isInSidebar   = $this->parent instanceof sidebar;
        $titleShow     = $this->prop('titleShow') ?? true;

        $header = $titleShow ? h::header
        (
            setClass('module-menu-header h-10 flex items-center pl-4 flex-none gap-3', $isInSidebar ? 'is-fixed rounded rounded-r-none canvas' : ''),
            span
            (
                setClass('module-title text-lg font-semibold clip'),
                $title
            ),
            $this->buildCloseBtn()
        ) : null;

        $hasToggleBtn = $this->prop('toggleSidebar') ?? true;

        return array
        (
            $isInSidebar ? $header : null,
            div
            (
                setID('teammateMenu'),
                setClass('module-menu shadow ring rounded bg-canvas col relative'),
                $this->block('header'),
                $isInSidebar ? null : $header,
                $this->buildMenuTree(),
                $this->block('footer'),
                ($hasToggleBtn) ? row
                (
                    setClass('justify-end p-1 flex-none'),
                    $hasToggleBtn ? btn
                    (
                        set::type('ghost'),
                        set::size('sm'),
                        set::icon('menu-arrow-left text-gray'),
                        set::hint($app->lang->collapse),
                        on::click()->do('$this.closest(".sidebar").sidebar("toggle");')
                    ) : null
                ) : null,
                $isInSidebar && !empty($header) ? on::init()->do('$("#mainContainer").addClass("has-module-menu-header")') : null
            ),
       );
    }
}
