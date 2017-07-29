<template>
    <div class="mw">
        <div class="mw" v-if="arrayCheck(items)">
            <div class="mw item" v-for="(wish, index) in items" :key="wish.id">
                <wish :data="wish"
                      :wait="disabled"
                      @disable="disabled = true"
                      @enable="disabled = false"
                      @donated="refresh(index)">
                    <h3 slot="header" v-text="$t('random')"></h3>
                </wish>
            </div>
        </div>
        <div class="mw" v-else>
            <div class="wish mw">
                <h3 v-text="$t('random')"></h3>
                <div class="flex center no-results bg-white">
                    <p class="w8 t-align" v-text="$t('no-relevant-results')"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Wish from '../wishes/Wish.vue';

    export default {
        components: { Wish },
        props: ['wishes'],
        data() {
            return {
                items: this.wishes,
                disabled: false
            }
        },
        methods: {
            refresh(index) {
                setTimeout(() => {
                    axios.post('/wishes/refresh', {
                        'set': [0]
                    }).then((response) => {
                        if (response.data[0] == null) {
                            this.items.splice(index, 1);
                        } else {
                            this.items.splice(index, 1, response.data[0]);
                        }
                        this.disabled = false;
                    });
                }, 500)
            },
            arrayCheck(array) {
                return (array.length > 0);
            }
        }
    }
</script>