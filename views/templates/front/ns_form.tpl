{extends file=$layout}
{block name='content'}
    <form action="{$ns_page_link|escape:'html'}" method="post" style="margin: auto; max-width: 800px;">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Mensualité par mois</label>
                    <input type="number" value="{$price_by_month}" name="price_mensuality" style="width: 100%; height: 36px" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nombre de mensualité</label>
                    <input type="email" value="{$ns_page_monthly}" name="mensuality_number" style="width: 100%; height: 36px" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <div style="text-align: left;">
                    <label>Email</label>
                </div>
                <input type="email" value="" name="mail" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-3">
                <div style="text-align: left;">
                    <label>Nom</label>
                </div>
                <input type="text" value="" name="name" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-3">
                <div style="text-align: left;">
                    <label>Prénom</label>
                </div>
                <input type="text" value="" name="surname" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-3">
                <div style="text-align: left;">
                    <label>Date de naissance</label>
                </div>
                <input type="date" value="" name="birthday" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-4" style="margin-top: 10px">
                <div style="text-align: left;">
                    <label>Code postal</label>
                </div>
                <input type="number" pattern="[0-9]{4}" value="" name="postal" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-4" style="margin-top: 10px">
                <div style="text-align: left;">
                    <label>Adresse</label>
                </div>
                <input type="text" value="" name="address" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-4" style="margin-top: 10px">
                <div style="text-align: left;">
                    <label>Ville</label>
                </div>
                <input type="text" value="" name="city" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-4" style="margin-top: 10px">
                <div style="text-align: left;">
                    <label>Téléphone</label>
                </div>
                <input type="tel" value="" name="phone" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-8" style="margin-top: 10px">
                <div style="text-align: left;">
                    <label>Salaire</label>
                </div>
                <input type="number" value="" name="salary" style="width: 100%; height: 36px" required>
            </div>
            <div class="col-sm-6" style="padding-top: 10px">
                <div style="text-align: left;">
                    <label>Êtes-vous poursuivis judiciairement ?</label>
                    <input type="checkbox" value="" name="court">
                </div>
            </div>
            <div class="col-sm-6" style="padding-top: 10px">
                <div style="text-align: left;">
                    <label><a href="https://www.creditum.ch/mentions-legales.html">J'ai lu et j'accepte les termes du contrat</a></label>
                    <input type="checkbox" required>
                </div>
            </div>
            <input hidden value="{$ns_page_monthly}" name="payment_monthly">
            <input hidden value="{$ns_page_total}" name="price">
            <input hidden value="{$ns_page_id_cart}" name="id_cart">
            <input hidden value="{$ns_page_id_product}" name="id_product">
            <div class="col-sm-12" style="padding-top: 10px">
                <button style="width: 100%" type="submit" class="btn btn-primary" name="submit_request">Demande de financement</button>
            </div>
            <div class="col-sm-6">
                <a style="font-size: 8px">Exemple de calcul: crédit de CHF 10'000.–. Un taux d’intérêt annuel effectif entre 4,4% et 9,95% et une durée de 12 mois engendrent des intérêts totaux entre CHF 235.– et CHF 523.–. Durées: 6-120 mois; Taux d'intérêt annuel maximum (y compris tous les frais du crédit) 9,95%. L'octroi de crédit est interdit, s'il entraîne le surendettement du consommateur. (Art. 3 LCD)</a>
            </div>
            <div class="col-sm-12">
                <a style="font-size: 8px" href="https://www.creditum.ch/mentions-legales.html">
                    Voir les termes
                </a>
            </div>
        </div>
    </form>
{/block}

<script>
    console.log({$ns_page_total});
</script>