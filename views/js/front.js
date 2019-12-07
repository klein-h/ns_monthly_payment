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
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */

function raisePower(x,y) {
    return Math.pow(x,y)
}

function calcVPM(mnt,taux,duree)
{

    let mensualite = 0;
    mensualite = mnt * ( (taux/12) /(1-raisePower((1+ (taux/12) ),-duree)));
    return mensualite;
}


let slider = window.document.getElementById("myRange");
let output = window.document.getElementById("total");
let payement = window.document.getElementById("payment_monthly");
if (slider !== null) {
    if (payement !== null) {
        payement.value = value;
        output.innerHTML =  "CHF " +      Math.ceil(calcVPM(total, 0.0895, payement.value)) + ".- /MOIS * " + payement.value;
    }
    else {
        output.innerHTML =  "CHF " +      Math.ceil(calcVPM(total, 0.0895, value)) + ".- /MOIS * " + value;
    }
    slider.oninput = function () {
        output.hidden = false;
        if (payement !== null){
            payement.value = this.value;
        }
        output.innerHTML =  "CHF " +     Math.ceil(calcVPM(total, 0.0895, this.value)) + ".- /MOIS * " + this.value;
    }
}