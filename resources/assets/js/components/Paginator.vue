<template>
    <ul class="paginator mw center" v-if="shouldPaginate">
        <li class="bg-white" :class="{disabled : !prevUrl}">
            <a @click.prevent="page--"><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{ $t('prev') }}</a>
        </li>
        <li class="bg-white" :class="{disabled : !nextUrl}">
            <a @click.prevent="page++">{{ $t('next') }} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
        </li>
    </ul>
</template>
<script>
    export default {
        props: ['dataSet', 'endpoint', 'other'],
        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },
            page() {
                this.broadcast().updateUrl();
            }
        },
        computed: {
            shouldPaginate() {
                return !! (this.prevUrl || this.nextUrl);
            }
        },
        methods: {
            broadcast() {
                if (this.page > this.dataSet.last_page || this.page <= 0) {
                    this.page = 1;
                }
                this.$emit('updated', this.page);

                return this;
            },
            updateUrl() {
                history.pushState(null, null, this.getUri());
            },
            getUri() {
                let regex = new RegExp(this.other + "=(\\d+)");
                let uri = location.search.match(regex) ? location.search.match(regex)[0] : '';
                if (uri != '') uri += '&';
                uri = '?' + uri + this.endpoint + '=' + this.page;
                return uri;
            }
        }
    }
</script>