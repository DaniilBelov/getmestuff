<template>
    <section>
        <div class="mw flex wrap between" v-if="arrayCheck(items)">
            <div class="container" v-for="(wish, index) in items" :key="wish.id">
                <wish :data="wish" :wait="disabled" @disable="disabled = true" @donated="refresh(index)"></wish>
            </div>
            <slot></slot>
        </div>
        <div class="mw flex center" v-else>
            <p>{{ $t('no-relevant-results') }}</p>
        </div>
    </section>
</template>
<script>
    import Wish from './Wish.vue';
    export default {
        components: { Wish },
        props: ['data'],
        data() {
            return {
                items: this.data,
                disabled: false,
            }
        },
        methods: {
            refresh(index) {
                let set = [];

                this.items.forEach((wish) => {
                    set.push(wish.id);
                });

                axios.post('/wishes/refresh', {
                    'set': set
                }).then((response) => {
                        if (response.data[0] == null) {
                            this.items.splice(index, 1);
                        } else {
                            this.items.splice(index, 1, response.data[0])
                        }
                        this.disabled = false;
                    });
            },
            arrayCheck(array) {
                return (array.length > 0);
            }
        }
    }
</script>