<div class="panel">
    <h3><i class="icon icon-tags"></i> {l s='Demande de financement' mod='ns_monthly_payment'}</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Email</th>
            <th>Number of month</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Address</th>
            <th>City</th>
            <th>Postal Code</th>
            <th>Birthday</th>
            <th>Number</th>
            <th>Salary</th>
            <th>Court ?</th>
            <th>Total cart</th>
            <th>Product / cart</th>
            <th>Send to credits company</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {foreach $ns_page_monthly as $data }
            <tr>
                <td>{$data['email']}</td>
                <td>{$data['monthly_value']}</td>
                <td>{$data['name']}</td>
                <td>{$data['surname']}</td>
                <td>{$data['address']}</td>
                <td>{$data['city']}</td>
                <td>{$data['postal']}</td>
                <td>{$data['birthday']}</td>
                <td>{$data['phone']}</td>
                <td>{$data['salary']}</td>
                <td>
                    {if $data['court'] == 1}
                        Yes
                    {else}
                        No
                    {/if}
                </td>
                <td>{$data['total']}</td>
                <td><a href="{$data['link']}{$ns_page_token}">Link</a><td>
                    {if $data['send'] == 1}
                        Yes
                    {else}
                        No
                    {/if}
                </td>
                <td>
                    <form action="{$ns_page_link}" method="post">
                        <input hidden value="{$data['id']}" name="id">
                        <input hidden value="{$data['email']}" name="email">
                        <input hidden value="{$data['name']}" name="name">
                        <input hidden value="{$data['surname']}" name="surname">
                        <input hidden value="{$data['address']}" name="address">
                        <input hidden value="{$data['birthday']}" name="birthday">
                        <input hidden value="{$data['city']}" name="city">
                        <input hidden value="{$data['salary']}" name="salary">
                        <input hidden value="{$data['postal']}" name="postal">
                        <input hidden value="{$data['court']}" name="court">
                        <input hidden value="{$data['monthly_value']}" name="monthly_value">
                        <input hidden value="{$data['total']}" name="total">
                        <input hidden value="{$data['phone']}" name="phone">
                        <button type="submit" class="btn btn-danger" name="submit_delete">Delete</button>
                        <button type="submit" class="btn btn-default" name="submit_mail">Send mail</button>
                    </form>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>