<h3 class="box-title">Manage Users' Activity</h3>
<my-table get="/admin/api/users/activity"
          post="/admin/api/users/activity"
          :columns="[
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'balance' },
                        { data: 'number_of_wishes' },
                        { data: 'priority' },
                        { data: 'points' },
                        { data: 'amount_donated' },
                        { data: 'amount_received' },
                        { data: 'ref_link' },
                        { data: 'updated_at' },
                        { data: 'created_at' }
                     ]"
          :skip="['id', 'created_at', 'updated_at', 'name']">
    <template slot="header">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Balance</th>
            <th>No. Wishes</th>
            <th>Priority</th>
            <th>Points</th>
            <th>Donated</th>
            <th>Received</th>
            <th>Ref Link</th>
            <th>Registered</th>
            <th>Last Action</th>
        </tr>
    </template>
</my-table>