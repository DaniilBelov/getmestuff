<h3 class="box-title">Manage All Users</h3>
<my-table get="/admin/api/users"
          post="/admin/api/users"
          :columns="[
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'verified' },
                        { data: 'balance' },
                        { data: 'donated' },
                        { data: 'status' },
                        { data: 'admin' },
                        { data: 'created_at' }
                     ]"
          :checkboxes="['verified', 'admin', 'donated']"
          :radio="['verified', 'admin', 'donated']"
          :skip="['id', 'created_at', 'name']">
    <template slot="header">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Verified</th>
            <th>Balance</th>
            <th>Donated</th>
            <th>Status</th>
            <th>Admin</th>
            <th>Registered</th>
        </tr>
    </template>
</my-table>