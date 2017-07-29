<h3 class="box-title">Manage All Achievements</h3>
<my-table get="/admin/api/achievements"
          post="/admin/api/achievements"
          :columns="[
                        { data: 'translations.en.title' },
                        { data: 'translations.ru.title' },
                        { data: 'translations.en.description' },
                        { data: 'translations.ru.description' },
                        { data: 'need' },
                        { data: 'prize' },
                        { data: 'renew_slug' },
                        { data: 'type' },
                     ]"
          :skip="['id', 'renew_slug', 'type_slug', 'updated_at', 'created_at', 'title', 'description']"
          :select="{ 'renew' : {0:'None', 1:'Monthly', 2:'Instant'} }">
    <template slot="header">
        <tr>
            <th colspan="2">Title</th>
            <th colspan="2">Description</th>
            <th rowspan="2">Amount Needed</th>
            <th rowspan="2">Points</th>
            <th rowspan="2">Renew</th>
            <th rowspan="2">Type</th>
        </tr>
        <tr>
            <th>EN</th>
            <th>RU</th>
            <th>EN</th>
            <th>RU</th>
        </tr>
    </template>
</my-table>