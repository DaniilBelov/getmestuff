<h3 class="box-title">Manage All Tickets</h3>
<my-table get="/admin/api/tickets"
          post="/admin/api/tickets"
          answer="true"
          :columns="[
                        { data: 'id' },
                        { data: 'email' },
                        { data: 'subject' },
                        { data: 'body' },
                        { data: 'priority_slug' },
                        { data: 'type_slug' },
                        { data: 'created_at' },
                        { data: 'updated_at' },
                     ]"
          :skip="['id', 'email', 'subject', 'body', 'created_at', 'updated_at', 'type_slug', 'priority_slug', 'unique_id']"
          :select="{
          'priority' : {0:'Green', 1:'Yellow', 2:'Red'},
          'type' : {0:'Open', 1:'In Progress', 2:'Closed'},
          }">
    <template slot="header">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Body</th>
            <th>Priority</th>
            <th>Type</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
    </template>
</my-table>