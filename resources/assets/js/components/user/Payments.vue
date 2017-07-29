<template>
    <div class="wallet-notification w48">
        <div class="notification bg-white mw flex vertical start">
            <h3 class="mw" v-text="$t('transactions')"></h3>
            <div class="mw" v-if="arrayCheck(items)">
                <payment v-for="payment in items" :data="payment" :key="payment.id"></payment>
            </div>
            <div class="mw flex center empty" v-else>
                <p v-text="$t('no-transactions')"></p>
            </div>
        </div>
        <paginator :dataSet="dataSet" @updated="fetch" endpoint="transactions" other="donations"></paginator>
    </div>
</template>
<script>
    import Payment from './Payment.vue';

    export default {
        components: { Payment },
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
                    let query = location.search.match(/transactions=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return '/payments?page=' + page;
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
            },
            arrayCheck(array) {
                return (array.length > 0);
            }
        },
    }
</script>