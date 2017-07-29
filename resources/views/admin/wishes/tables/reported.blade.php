<h3 class="box-title">Manage Reported Wishes</h3>
<my-table get="/admin/api/wishes/reported"
          post="/admin/api/wishes"
          :columns="[
                        { data: 'translations.en.item' },
                        { data: 'translations.ru.item' },
                        { data: 'user_id' },
                        { data: 'validated' },
                        { data: 'created_at' }
                     ]"
          :checkboxes="['validated']"
          :radio="['validated']"
          :skip="['id', 'user_id', 'created_at', 'item']">
    <template slot="header">
        <tr>
            <th colspan="2">Item</th>
            <th rowspan="2">User ID</th>
            <th rowspan="2">Validated</th>
            <th rowspan="2">Created At</th>
        </tr>
        <tr>
            <th>EN</th>
            <th>RU</th>
        </tr>
    </template>
</my-table>