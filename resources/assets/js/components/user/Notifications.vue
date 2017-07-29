<template>
    <div class="w48">
        <div class="mw" v-if="arrayCheck(dataSet.total)">
            <notification v-for="(notification, key) in items" :data="notification" :date="key" :key="key"></notification>
        </div>

        <div class="mw flex center bg-white empty border" v-else>
            <p v-text="$t('no-notifications')"></p>
        </div>

        <paginator :dataSet="dataSet" @updated="fetch" endpoint="donations" other="transactions"></paginator>
    </div>
</template>
<script>
    import Notification from './Notification.vue';

    export default {
        components: { Notification },
        data() {
            return {
                items: [],
                dataSet: false
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },
            url(page) {
                if (!page) {
                    let query = location.search.match(/donations=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return '/donations?page=' + page;
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
            },
            arrayCheck(temp) {
                return (temp > 0);
            }
        },
    }
</script>