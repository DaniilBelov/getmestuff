<h3 class="box-title">Manage All Prizes</h3>
<my-table get="/admin/api/achievements/prizes"
          post="/admin/api/achievements/prizes"
          :columns="[
                        { data: 'translations.en.item' },
                        { data: 'translations.ru.item' },
                        { data: 'translations.en.description' },
                        { data: 'translations.ru.description' },
                        { data: 'user_column' },
                        { data: 'bought' },
                        { data: 'price' },
                     ]"
          :skip="['id', 'bought', 'updated_at', 'created_at', 'item', 'description']">
    <template slot="header">
        <tr>
            <th colspan="2">Item</th>
            <th colspan="2">Description</th>
            <th rowspan="2">User Column</th>
            <th rowspan="2">Bought</th>
            <th rowspan="2">Price</th>
        </tr>
        <tr>
            <th>EN</th>
            <th>RU</th>
            <th>EN</th>
            <th>RU</th>
        </tr>
    </template>
</my-table>