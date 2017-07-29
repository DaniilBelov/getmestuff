<template>
    <form class="vertical mw start">
        <label class="flex mw prize-option" v-for="prize in prizes" :class="{ disable : (prize.id == 3 && limit)}">
            <input :disabled="(prize.id == 3 && limit)" type="radio" name="prize" class="radio" :value="prize.id" v-model="selected" checked>
            <div class="prize-info mw flex vertical start">
                <h4 v-text="prize.item"></h4>
                <p v-text="prize.description"></p>
                <p class="self-end">{{ prize.price }} <i class="currency fa fa-trophy" aria-hidden="true"></i></p>
            </div>
        </label>
        <div class="mw flex quantity">
            <div>
                <p>{{ $t('total') }}: {{ price }} <i class="currency fa fa-trophy" aria-hidden="true"></i></p>
            </div>
            <div class="flex start form">
                <input @blur="setQuantity" name="quantity" type="text" value="1" v-model="quantity" :disabled="isLimit">
                <button :disabled="buffering" @click.prevent="redeemPoints">GO!</button>
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        props: ['user', 'prizes'],
        data() {
            return {
                selected: "1",
                quantity: 1,
                limit: '',
                buffering: false,
                items: ''
            }
        },
        computed: {
            price() {
                if (this.selected > 0) {
                    return this.prizes[this.selected - 1].price * this.quantity;
                } else {
                    return 0;
                }
            },
            isLimit() {
                if (this.selected == 3) {
                    this.quantity = 1;
                    return true;
                } else {
                    return false;
                }
            },
        },
        methods: {
            setQuantity() {
                if (this.quantity == '' || this.quantity == 0) {
                    this.quantity = 1;
                }
            },
            redeemPoints() {
                this.buffering = true;
                axios.post('/home/achievements', {
                    'selected': this.selected,
                    'quantity': this.quantity
                })
                    .then(() => {
                        if (this.selected == 3) this.limit = true;
                        this.buffering = false;

                        let message = window.flashMessages[window.App.locale]['redeemed'];
                        flash([message]);

                        window.events.$emit('pointsDown', this.price);
                        if (this.selected == 1) {
                            window.events.$emit('moreWishes', this.quantity);
                        }
                    })
                    .catch((error) => {
                        this.buffering = false;
                        let messages = [];
                        for (let key in error.response.data) {
                            messages.push(error.response.data[key][0]);
                        }

                        this.buffering = false;
                        flash(messages, 'error');
                    });
            }
        },
        created() {
            this.limit = (this.user == 1);
        }
    }
</script>