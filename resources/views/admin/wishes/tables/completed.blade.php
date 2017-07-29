<h3 class="box-title">Manage All Wishes</h3>
<my-table get="/admin/api/wishes/completed"
          post="/admin/api/wishes"
          :columns="[
                        { data: 'url' },
                        { data: 'total_current_amount' },
                        { data: 'amount_needed' },
                        { data: 'address.address_line' },
                        { data: 'address.city' },
                        { data: 'address.post_code' },
                        { data: 'address.country' },
                        { data: 'processed' }
                     ]"
          :radio="['processed', 'completed']"
          :checkboxes="['processed']"
          :skip="['id', 'total_current_amount', 'item', 'translations']">
    <template slot="header">
        <tr>
            <th rowspan="2">URL</th>
            <th rowspan="2">Current Amount</th>
            <th rowspan="2">Amount Needed</th>
            <th colspan="4">Address</th>
            <th rowspan="2">Processed</th>
        </tr>
        <tr>
            <th>Address</th>
            <th>City</th>
            <th>Code</th>
            <th>Country</th>
        </tr>
    </template>
</my-table>