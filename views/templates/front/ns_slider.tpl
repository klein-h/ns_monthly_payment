<!-- Block ns_monmodule -->
<div class="card cart-summary">
  <div>
    <div class="card-block">
      <div class="cart-summary-line" id="cart-subtotal-products">
          <span class="label js-subtotal">
           PAIEMENT MENSUEL
             <a style="font-size: 8px">Disponible uniquement en suisse</a>
          </span>
      </div>
    </div>
    <div class="card-block">
      <div class="cart-summary-line" id="cart-subtotal-products">
        <div class="range">
          <input
                  class="slider"
                  type="range"
                  min="{$ns_page_array[0]}"
                  max="{$ns_page_array[count($ns_page_array) - 1]}"
                  value="{$ns_page_array[count($ns_page_array) - 1]}"
                  step="1"
                  id="myRange"
                  style="width: 100%;">
          <div class="sliderticks">
            {foreach from=$ns_page_array key=k item=data}
              <p {if $k !== 0 && $k !== 13 && $k !== 27 &&  $k !== 41 && $k !== 55 && $k !== 69 &&  $k !== 83} hidden {/if}>{$data}</p>
            {/foreach}
          </div>
        </div>
      </div>
    </div>
    <div class="card-block">
      <div class="cart-summary-line" id="cart-subtotal-products">
        <a class="label js-subtotal" id="total" style="font-size: 26px; color: black">
          CHF {$ns_page_total}.- /MOIS
        </a>
      </div>
    </div>
  </div>
  <div class="checkout card-block" style="width: 100%">
    <div class="text-sm-center">
      <form action="{$ns_page_link|escape:'html'}" method="post">
        <input hidden value="{$ns_page_array[0]}" name="payment_monthly" id="payment_monthly">
        <input hidden value="{$ns_page_total}" name="price">
        <input hidden value="{$ns_page_id_cart}" name="id_cart">
        <button style="width: 100%" type="submit" class="btn btn-primary" name="go_to_form">Financement</button>
        <a style="font-size: 8px">L'octroi de crédit est interdit, s'il entraîne le surendettement du consommateur. (Art. 3 LCD)</a>
      </form>
    </div>
  </div>
</div>
<script>

  var total = {$ns_page_total};
  var value = {$ns_page_array[count($ns_page_array) - 1]};

</script>


<!-- /Block ns_monmodule -->
