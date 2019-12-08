<?php


class AdminMonthlyPaymentController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap=true;
    }

    public function initContent() {
        parent::initContent();
        $query = 'SELECT * FROM ns_monthly_payment';
        $data = Db::getInstance()->ExecuteS($query);
        $this->context->smarty->assign(['ns_page_monthly' => $data, 'ns_page_link' => $this->context->link->getAdminLink('AdminMonthlyPayment'), 'ns_page_token' =>Tools::getAdminToken('AdminCarts'.intval(Tab::getIdFromClassName('AdminCarts')).intval($this->context->cookie->id_employee))]);
        return $this->setTemplate('table.tpl');
    }


    public function getContent() {
        $query = 'SELECT * FROM ns_monthly_payment';
        $data = Db::getInstance()->ExecuteS($query);
        $this->context->smarty->assign(['ns_page_monthly' => $data, 'ns_page_link' => $this->context->link->getAdminLink('AdminMonthlyPayment')]);
        return $this->setTemplate('table.tpl');
    }


    public function sendMail($id, $monthly, $email, $total, $phone, $name, $surname, $address, $birthday, $city, $salary, $postal, $court) {
        $send = 1;
        $is_court = "Non";
        if ($court == 1) {
            $is_court = "Oui";
        }
        $query =  Db::getInstance()->Execute('UPDATE ns_monthly_payment SET send ='. (int)$send . ' where id = '. (int)$id . ';');
        Mail::Send((int)(Configuration::get('PS_LANG_DEFAULT')), // defaut language id
            'reply_msg', // email template file to be use
            'Demande de financement', // email subject
            array(
                '{reply}' => "Bonjour,\n
                    Un nouveau client demande un financement à hauteur de " .$total . " échelonné sur " . $monthly. " mensualité(s).\n
                    Email du client : ". $email . " <br>
                    Numéro du client : ". $phone . "  <br>                 
                    Nom/Prénom : ". $name . " ". $surname . "<br>
                    Date de naissance : ". $birthday . " <br>
                    Adresse : ". $address . "<br> 
                    Ville : ". $city . " <br> 
                    Code postal : ". $postal . " <br>
                    Salaire : ". $salary . " <br> 
                    Poursuite Judiciaire : ". $is_court . " <br>                                                                                               
                ",
                '{firstname}' => 'Monsieur,',
                '{lastname}' => 'Madame',
                '{link}' => Configuration::get('PS_SHOP_EMAIL')
            ),
            Configuration::get('NS_MONTHLY_PAYMENT_ACCOUNT_EMAIL'), // receiver email address
            NULL, NULL, NULL);
        Tools::redirect($this->context->link->getAdminLink('AdminMonthlyPayment', false)
            .'&token='. Tools::getAdminTokenLite('AdminMonthlyPayment'));
    }

    public function delete($id) {
        $query =  Db::getInstance()->Execute('DELETE FROM ns_monthly_payment where id = '. (int)$id . ';');
        Tools::redirect($this->context->link->getAdminLink('AdminMonthlyPayment', false)
            .'&token='. Tools::getAdminTokenLite('AdminMonthlyPayment'));
    }

    public function postProcess(){
        if (Tools::isSubmit('submit_delete')) {
            $this->delete($_POST['id']);
        }
        elseif (Tools::isSubmit('submit_mail')) {
            $this->sendMail($_POST['id'], $_POST['monthly_value'], $_POST['email'], $_POST['total'], $_POST['phone'], $_POST['name'], $_POST['surname'], $_POST['address'], $_POST['birthday'], $_POST['city'], $_POST['salary'], $_POST['postal'], $_POST['court']);
        }
    }

}