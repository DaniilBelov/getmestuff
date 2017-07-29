<h3 class="box-title">Manage Wishes' Address</h3>
<my-table get="/admin/api/wishes/address"
          post="/admin/api/wishes/address"
          :columns="[
                        { data: 'item' },
                        { data: 'user' },
                        { data: 'address.address_line' },
                        { data: 'address.city' },
                        { data: 'address.post_code' },
                        { data: 'address.country' },
                     ]"
          :skip="['id', 'created_at', 'user', 'user_id', 'address_line']">
    <template slot="header">
        <tr>
            <th rowspan="2">Item</th>
            <th rowspan="2">User Email</th>
            <th colspan="6">Full Address</th>
        </tr>
        <tr>
            <th>Address</th>
            <th>City</th>
            <th>Code</th>
            <th>Country</th>
        </tr>
    </template>
</my-table>