<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

class DemoHelperOptions extends Module
{
    /**
     * Name of ModuleAdminController used for configuration
     */
    const MODULE_ADMIN_CONTROLLER = 'AdminDemoHelperOptions';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->name = 'demohelperoptions';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Matt75';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.5.0.0',
            'max' => _PS_VERSION_,
        ];

        parent::__construct();

        $this->displayName = $this->l('Demo HelperOptions');
        $this->description = $this->l('Adds a ModuleAdminController with HelperOptions usage example');
    }

    /**
     * Install Module.
     *
     * @return bool
     */
    public function install()
    {
        return parent::install()
            && $this->installTabs();
    }

    /**
     * Install Tabs
     *
     * @return bool
     */
    public function installTabs()
    {
        if (Tab::getIdFromClassName(static::MODULE_ADMIN_CONTROLLER)) {
            return true;
        }

        $tab = new Tab();
        $tab->class_name = static::MODULE_ADMIN_CONTROLLER;
        $tab->module = $this->name;
        $tab->active = true;
        $tab->id_parent = -1;
        $tab->name = array_fill_keys(
            Language::getIDs(false),
            $this->displayName
        );

        return (bool) $tab->add();
    }

    /**
     * Uninstall Module
     *
     * @return bool
     */
    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallTabs();
    }

    /**
     * Uninstall Tabs
     *
     * @return bool
     */
    public function uninstallTabs()
    {
        $id_tab = (int) Tab::getIdFromClassName(static::MODULE_ADMIN_CONTROLLER);

        if ($id_tab) {
            $tab = new Tab($id_tab);

            return (bool) $tab->delete();
        }

        return true;
    }

    /**
     * Redirect to our ModuleAdminController when click on Configure button
     */
    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink(static::MODULE_ADMIN_CONTROLLER));
    }
}
