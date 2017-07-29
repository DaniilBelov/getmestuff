<h3 class="box-title">Manage All Wishes</h3>
<my-table get="/admin/api/wishes"
          post="/admin/api/wishes"
          :columns="[
                        { data: 'translations.en.item' },
                        { data: 'translations.ru.item' },
                        { data: 'current_amount' },
                        { data: 'amount_needed' },
                        { data: 'validated' },
                        { data: 'completed' },
                        { data: 'created_at' }
                     ]"
          :checkboxes="['validated', 'completed']"
          :radio="['validated', 'completed']"
          :skip="['id', 'created_at', 'item']">
    <template slot="header">
        <tr>
            <th colspan="2">Item</th>
            <th rowspan="2">Current Amount</th>
            <th rowspan="2">Amount Needed</th>
            <th rowspan="2">Validated</th>
            <th rowspan="2">Completed</th>
            <th rowspan="2">Created At</th>
        </tr>
        <tr>
            <th>EN</th>
            <th>RU</th>
        </tr>
    </template>
</my-table>