<template>
    <div class="notification bg-white mw flex vertical start">
        <h3 class="mw">{{ when }}</h3>

        <div class="notification-info mw" v-for="(item, key) in data">
            <h4>{{ key }} <i class="fa fa-check-circle" aria-hidden="true" v-if="'completed' in item"></i></h4>
            <p v-if="window.App.locale == 'en'">
                Donated: {{ item['total'] }}$ by {{ item['count'] }} {{ item['count'] > 1 ? 'users' : 'user' }}.
            </p>
            <p v-else>
                Дано: {{ item['total'] }}$ {{ item['count'] }} {{ item['count'] > 1 ? 'пользователями' : 'пользователем' }}.
            </p>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';

    export default {
        props: ['data', 'date'],
        computed: {
            when() {
                let check = moment();
                let date = moment(this.date, "YY-MM-DD");
                if (check.diff(date, 'days') == 0) {
                    return $t('today');
                } else if (check.diff(date, 'days') == 1) {
                    return $t('yesterday');
                }
                return date.format('DD-MM-YYYY');
            }
        }
    }
</script>