<h3 class="box-title">Manage Open Tickets</h3>
<my-table get="/admin/api/payments/failed"
          post="/admin/api/payments"
          :columns="[
                        { data: 'id' },
                        { data: 'user_id' },
                        { data: 'braintree_id' },
                        { data: 'successful' },
                        { data: 'amount' },
                        { data: 'interest' },
                        { data: 'created_at' },
                     ]"
          :skip="['id', 'user_id', 'braintree_id', 'amount', 'interest', 'created_at']"
          :checkboxes="['successful']"
          :radio="['successful']"
>
    <template slot="header">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>BrainTree ID</th>
            <th>Successful</th>
            <th>Amount</th>
            <th>Interest</th>
            <th>Created</th>
        </tr>
    </template>
</my-table>