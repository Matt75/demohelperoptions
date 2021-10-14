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
class AdminDemoHelperOptionsController extends ModuleAdminController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'Configuration';
        $this->table = 'configuration';

        parent::__construct();

        $this->fields_options = [
            'fieldset1' => [
                'icon' => 'icon-cogs',
                'class' => 'css-fieldset1',
                'title' => $this->l('Demo allowed values check'),
                'description' => $this->l('Please use developer tools of your browser and changes value of selected option or radio input with an unknown value, submit form and as you will see unknown value will be accepted.'),
                'fields' => [
                    'DEMOHELPEROPTIONS_SELECT_VALUE' => [
                        'title' => $this->l('Choose a value'),
                        'desc' => $this->l('Please use developer tools of your browser and changes value of selected option with an unknown value.'),
                        'required' => false,
                        'type' => 'select',
                        'identifier' => 'id',
                        'list' => [
                            [
                                'id' => 'SELECT1',
                                'name' => 'Value 1',
                            ],
                            [
                                'id' => 'SELECT2',
                                'name' => 'Value 2',
                            ],
                            [
                                'id' => 'SELECT3',
                                'name' => 'Value 3',
                            ],
                            [
                                'id' => 'SELECT4',
                                'name' => 'Value 4',
                            ],
                        ],
                    ],
                    'DEMOHELPEROPTIONS_RADIO' => [
                        'title' => $this->l('Choose a value'),
                        'desc' => $this->l('Please use developer tools of your browser and changes value of selected radio input with an unknown value.'),
                        'required' => false,
                        'type' => 'radio',
                        'choices' => [
                            'RADIO1' => $this->module->l('First value'),
                            'RADIO2' => $this->module->l('Second value'),
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    /**
     * Provided to test https://github.com/PrestaShop/PrestaShop/pull/25156
     *
     * {@inheritDoc}
     */
    public function beforeUpdateOptions()
    {
        if (Tools::getIsset('submitOptionsconfiguration')) {
            $this->informations[] = 'Field SELECT : value = ' . var_export(Tools::getValue('DEMOHELPEROPTIONS_SELECT_VALUE'), true);
            $selectAllowedValues = [];

            if (isset($this->fields_options['fieldset1']['fields']['DEMOHELPEROPTIONS_SELECT_VALUE']['list'])) {
                foreach ($this->fields_options['fieldset1']['fields']['DEMOHELPEROPTIONS_SELECT_VALUE']['list'] as $element) {
                    $selectAllowedValues[] = sprintf('%s (%s)', $element['id'], $element['name']);
                }
            }

            $this->informations[] = 'ALLOWED VALUES = ' . implode(', ', $selectAllowedValues);
            $this->informations[] = '---------------';
            $this->informations[] = 'Field RADIO : value = ' . var_export(Tools::getValue('DEMOHELPEROPTIONS_RADIO'), true);
            $radioAllowedValues = [];

            if (isset($this->fields_options['fieldset1']['fields']['DEMOHELPEROPTIONS_RADIO']['choices'])) {
                foreach ($this->fields_options['fieldset1']['fields']['DEMOHELPEROPTIONS_RADIO']['choices'] as $key => $value) {
                    $radioAllowedValues[] = sprintf('%s (%s)', $key, $value);
                }
            }

            $this->informations[] = 'ALLOWED VALUES = ' . implode(', ', $radioAllowedValues);
        }
    }
}
