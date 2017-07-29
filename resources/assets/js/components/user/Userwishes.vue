<template>
    <div class="mw">
        <div class="mw user-wishes owl-theme owl-carousel" v-if="arrayCheck(items)">
            <div class="mw item" v-for="(wish, index) in items" :key="wish.id">
                <wish @delete="removeWish(index)" :data="wish" :report="false" :displayForm="false">
                    <h3 slot="header" v-text="$t('user')"></h3>
                </wish>
            </div>
        </div>
        <div class="wish mw" v-else>
            <h3 v-text="$t('user')">Your Current Wish</h3>
            <div class="flex center no-results bg-white">
                <p class="w8 t-align" v-text="$t('no-wishes')"></p>
            </div>
        </div>
    </div>
</template>
<script>
    import Wish from '../wishes/Wish.vue'

    export default {
        components: {Wish},
        props: ['wishes'],
        data() {
            return {
                items: this.wishes,
            }
        },
        methods: {
            arrayCheck(array) {
                return (array.length > 0);
            },
            removeWish(index) {
                if (this.items.length == 1) {
                    $('.user-wishes').trigger('destroy.owl.carousel');
                    this.items.splice(index, 1);
                } else {
                    $('.user-wishes').trigger('remove.owl.carousel', index);
                    this.items.splice(index, 1);
                }
            },
            updateCarousel() {
                $(function () {
                    $('.user-wishes').trigger('destroy.owl.carousel');

                    $('.user-wishes').owlCarousel({
                        items: 1,
                        dots: false,
                        nav: true,
                        navText: [
                            '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                            '<i class="fa fa-chevron-right" aria-hidden="true"></i>']
                    });

                    $('.user-wishes').trigger('to.owl.carousel', $('.user-wishes .owl-item').length);
                });
            }
        },
        created() {
            window.events.$on('newWish', (wish) => {
                this.items.push(wish);

                this.updateCarousel();
            });
        }
    }
</script>