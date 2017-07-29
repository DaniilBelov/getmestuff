<template>
    <div class="notification-info mw pos-r">
        <h4>{{ date }}</h4>
        <p>{{ $t('wallet-top-up') }}: {{ data.amount }}$ <span>(+ {{ data.interest }})</span></p>
        <i class="pos-a fa fa-check-circle" aria-hidden="true" v-if="data.successful == 1"></i>
        <i class="pos-a fa fa-exclamation-circle" aria-hidden="true" v-else></i>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        props: ['data'],
        computed: {
            date() {
                return moment(this.data.created_at).format('MM-DD-YYYY');
            }
        }
    }
</script>