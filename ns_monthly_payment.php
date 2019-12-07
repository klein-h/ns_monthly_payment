<?php
/**
 * 2007-2019 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2019 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ns_monthly_payment extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'ns_monthly_payment';
        $this->tab = 'checkout';
        $this->version = '1.0.0';
        $this->author = 'Arthur Klein';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Monthly Payment Demand');
        $this->description = $this->l('This module bring management monthly payment inside prestashop checkout');

        $this->confirmUninstall = $this->l('Are you shure to want uninstall this module ? ');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('NS_MONTHLY_PAYMENT_LIVE_MODE', false);
        Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `ns_monthly_payment` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `send` INT( 11 ) UNSIGNED NOT NULL,
                                `monthly_value` VARCHAR(255) NOT NULL,
                                `email` VARCHAR(255) NOT NULL,
                                `address` VARCHAR(255) NOT NULL,
                                `name` VARCHAR(255) NOT NULL,
                                `surname` VARCHAR(255) NOT NULL,
                                `birthday` VARCHAR(255) NOT NULL,
                                `total` VARCHAR(255) NOT NULL,
                                `phone` VARCHAR(255) NOT NULL,
                                `salary` VARCHAR(255) NOT NULL,
                                `court` INT(11) NOT NULL,
                                `link` VARCHAR(255) NULL,
                                `city` VARCHAR(255) NOT NULL,                               
                                `postal` VARCHAR(255) NOT NULL,                                                                
                                PRIMARY KEY (`id`)
                                ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');

        return parent::install() && $this->installTab() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayReassurance');
    }

    private function installTab()
    {
        $class = 'AdminMonthlyPayment';
        $tabId = (int) Tab::getIdFromClassName($class);
        if (!$tabId) {
            $tabId = null;
        }
        $tab = new Tab($tabId);
        $tab->class_name = $class;
        $tab->id_parent = (int) Tab::getIdFromClassName('SELL');
        $tab->visible = true;
        $tab->module = $this->name;
        $langs = Language::getLanguages(false);
        foreach ($langs as $l) {
            $tab->name[$l['id_lang']] = $this->l('Demande de financement');
        }
        return $tab->save();
    }

    private function uninstallTab()
    {
        $tabId = (int) Tab::getIdFromClassName('AdminMonthlyPayment');
        if (!$tabId) {
            return true;
        }

        $tab = new Tab($tabId);

        return $tab->delete();
    }

    public function uninstall()
    {
        Db::getInstance()->execute(
            'DROP TABLE ns_monthly_payment');

        return parent::uninstall() && $this->uninstallTab();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitNs_monthly_paymentModule')) == true) {
            $this->postProcess();
        }
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitNs_monthly_paymentModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'NS_MONTHLY_PAYMENT_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Enter number of mensuality'),
                        'name' => 'NS_MONTHLY_PAYMENT_NUMBER',
                        'label' => $this->l('Number'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Enter size of mensuality'),
                        'name' => 'NS_MONTHLY_PAYMENT_SIZE',
                        'label' => $this->l('Size'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'NS_MONTHLY_PAYMENT_ACCOUNT_EMAIL' => Configuration::get('NS_MONTHLY_PAYMENT_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'NS_MONTHLY_PAYMENT_SIZE' => Configuration::get('NS_MONTHLY_PAYMENT_SIZE', '12'),
            'NS_MONTHLY_PAYMENT_NUMBER' => Configuration::get('NS_MONTHLY_PAYMENT_NUMBER', '4'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function onProductOrCheckout() {
        $context=Context::getContext();
        $id_cart=$context->cookie->id_cart;

        if($id_cart=='') $id_cart=Tools::getValue('id_cart');
        $theCart = new Cart($id_cart);
        $tmpProducts = $theCart->getProducts(true);
        $products = [];
        $totalPrice = $theCart->getOrderTotal(true);
        foreach ($tmpProducts as $product)
        {
            $products[] = (object) array('price' => $product['total_wt'], 'name' => $product['name'], 'quantity' => $product['cart_quantity'], 'id' => $product['id_product']);
        }
        $this->context->smarty->assign([
            'ns_page_array' => $this->createArrayMensuality(),
            'ns_page_link' => $this->context->link->getModuleLink($this->name, 'default'),
            'ns_page_products' => $products,
            'ns_page_total' => $totalPrice,
            'ns_page_id_cart' => $id_cart
        ]);
        return $totalPrice;
    }


    public function createArrayMensuality() {
        $size_one = (int)Configuration::get('NS_MONTHLY_PAYMENT_SIZE');
        $number = (int)Configuration::get('NS_MONTHLY_PAYMENT_NUMBER');


        $array = [];
        for ($i = 1; $i <= $number; $i++) {
            $array[] = $size_one * $i;
        }
        return $array;
    }

    public function hookDisplayMonthlyPayment() {
        $pid = $this->context->controller->getProduct()->id;
        $price = Product::getPriceStatic($pid);
        if ((int)$price > 2000) {
            $products[] = (object) array('price' => $price, 'name' => 'test', 'quantity' => 1, 'id' => $pid);
            $this->context->smarty->assign([
                'ns_page_array' => $this->createArrayMensuality(),
                'ns_page_link' => $this->context->link->getModuleLink($this->name, 'default'),
                'ns_page_products' => $products,
                'ns_page_id' => $pid,
                'ns_page_total' => $price,
            ]);
            return $this->display(__FILE__, 'ns_slider_product.tpl');
        }
    }


    public function hookDisplayReassurance()
    {
        if ((int)$this->onProductOrCheckout() > 2000) {
            return $this->display(__FILE__, 'ns_slider.tpl');
        }
    }
}
