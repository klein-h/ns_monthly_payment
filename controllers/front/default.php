<?php


class ns_monthly_paymentDefaultModuleFrontController extends ModuleFrontController
{

    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();

    }

    public function initContent() {
        parent::initContent();
        $value_by_month = ceil(((float)$_POST['price'] * (0.0895 / 12)) / (1 - pow((1 + 0.0895 / 12), -1 * (int)$_POST['payment_monthly'])));
        if (!isset($_POST['id_cart'])) {
            $id_cart = null;
        }
        else {
            $id_cart = $_POST['id_cart'];
        }
        if (!isset($_POST['id_product'])) {
            $id_product = null;
        }
        else {
            $id_product = $_POST['id_product'];
        }
        $this->context->smarty->assign(['ns_page_link' => $this->context->link->getModuleLink('ns_monthly_payment', 'default'), 'ns_page_monthly' => $_POST['payment_monthly'], 'ns_page_total' => $_POST['price'], 'price_by_month' => $value_by_month, 'ns_page_id_product' => $id_product, 'ns_page_id_cart' => $id_cart]);
        return $this->setTemplate('module:ns_monthly_payment/views/templates/front/ns_form.tpl');
    }



    public function insetInsideDb($monthly_value, $total, $email, $address, $name, $surname, $birthday, $phone, $salary, $postal, $city, $id_cart, $id_product, $court) {
        $send = 0;
        if (strlen($id_product) === 0) {
            $link = '/admin805d3ibsr/index.php?controller=AdminCarts&viewcart=1&id_cart='. $id_cart
                .'&token=';
        }
        else {
            $link = '/admin805d3ibsr/index.php/sell/catalog/products/' . $id_product . '?token=';
        }
        $query =  Db::getInstance()->Execute('INSERT INTO ns_monthly_payment (monthly_value, total, email, send, address, name, surname, birthday, phone, salary, postal, city, link, court) VALUES 
                                                                                                                                                                     ("' .$monthly_value.'","'.$total .'"," ' . $email .'", "'. $send .'", "'. $address .'","' .$name . '","' .$surname . '","' .$birthday . '","' . $phone. '","' . $salary. '","' . $postal. '","' . $city. '","' . $link. '","' . $court. '");');

        if (!$query) {
            $this->error[] = $this->l('Something went wrong');
            $this->redirectWithNotifications('index.php?controller=cart&action=show');
        }
        else {
            $this->success[] = $this->l('We received your credit demand');
            $this->redirectWithNotifications('index.php?controller=cart&action=show');
            $context=Context::getContext();
            $id_cart=$context->cookie->id_cart;

            if($id_cart=='') $id_cart=Tools::getValue('id_cart');

            $theCart = new Cart($id_cart);
            $prods = $theCart->getProducts();

            foreach ($prods as $prod)
                $theCart->deleteProduct($prod['id_product']);
        }
    }

    public function postProcess(){
        if (Tools::isSubmit('submit_request')) {
            if (!isset($_POST['court'])) {
                $court = 0;
            }
            else {
                $court = $_POST['court'];
            }
            $this->insetInsideDb($_POST['payment_monthly'], $_POST['price'], $_POST['mail'], $_POST['address'], $_POST['name'], $_POST['surname'], $_POST['birthday'], $_POST['phone'], $_POST['salary'], $_POST['postal'], $_POST['city'], $_POST['id_cart'], $_POST['id_product'], $court);
        }
    }

}