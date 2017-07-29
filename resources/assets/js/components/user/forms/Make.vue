<template>
    <section class="flex vertical start bg-white main-section" id="wish" v-if="allowed == 1">
        <div class="flex between mw wish-title-wrapper">
             <div class="flex center wish-title">
                <h2 v-text="$t('wish')"></h2>
                <span v-text="number_of_wishes"></span>
            </div>
            <div class="priority" v-if="priority > 0">
                <p v-text="$t('priority')"></p>
            </div>
        </div>
        <form class="vertical center mw" data-parsley-validate autocomplete="off">
            <div class="vertical mw center">
                <div class="mw pos-r">
                    <input type="text"
                           name="item"
                           v-model="item"
                           :placeholder="$t('item')"
                           required>
                </div>
                <div class="mw pos-r">
                    <input type="url"
                           data-parsley-trigger="change"
                           name="url"
                           v-model="url"
                           :placeholder="$t('link')"
                           required>
                </div>
            </div>
            <div class="radio-group flex mw">
                <label :class="{ active: currency == 'usd' }">
                    <input type="radio" name="currency" value="usd" v-model="currency" :checked="currency == 'usd'"/> USD
                </label>
                <label :class="{ active: currency == 'rub' }">
                    <input type="radio" name="currency" v-model="currency" value="rub" :checked="currency == 'rub'"/> RUB
                </label>
                <label :class="{ active: currency == 'eur' }">
                    <input type="radio" name="currency" v-model="currency" value="eur" :checked="currency == 'eur'"/> EUR
                </label>
                <label :class="{ active: currency == 'gbp' }">
                    <input type="radio" name="currency" v-model="currency" value="gbp" :checked="currency == 'gbp'"/> GBP
                </label>
            </div>
            <div class="flex between mw small-input-wrapper">
                <div class="w48 pos-r">
                    <input type="number"
                           name="current_amount"
                           v-model="current_amount"
                           :placeholder="$t('current')"
                           required>
                </div>
                <div class="w48 pos-r">
                    <input type="number"
                           name="amount_needed"
                           v-model="amount_needed"
                           :placeholder="$t('needed')"
                           required>
                </div>
            </div>
            <div class="mw divisor divisor-bg">
                <p><i class="fa fa-address-card-o" aria-hidden="true"></i><span v-text="$t('address')"></span></p>
                <div class="mw pos-r">
                    <input type="text"
                           name="address_one"
                           v-model="address_one"
                           :placeholder="$t('address1')"
                           required>
                </div>
                <div class="mw pos-r">
                    <input type="text"
                           name="address_two"
                           v-model="address_two"
                           :placeholder="$t('address2')">
                </div>
                <div class="mw flex between small-input-wrapper">
                    <div class="w3 pos-r">
                        <input type="text"
                               name="city"
                               v-model="city"
                               :placeholder="$t('city')"
                               required>
                    </div>
                    <div class="w3 pos-r">
                        <input type="text"
                               name="post_code"
                               v-model="post_code"
                               :placeholder="$t('zip')"
                               required>
                    </div>
                    <div class="w3 pos-r">
                        <input type="text"
                               name="country"
                               v-model="country"
                               :placeholder="$t('country')"
                               required>
                    </div>
                </div>
            </div>
            <div class="self-start">
                <button class="pos-r" :disabled="buffering" @click.prevent="postWish" type="submit">
                    <i v-show="buffering" class="fa fa-refresh fa-spin pos-a fa-lg" aria-hidden="true"></i>
                    {{ $t('request') }}
                </button>
            </div>
        </form>
    </section>
    <section class="flex center bg-white main-section empty" v-else>
        <p v-text="$t('not-donated')"></p>
    </section>
</template>
<script>
    import moment from 'moment';

    export default {
        props: ['user', 'last_currency'],
        data() {
            return {
                item: '',
                url: '',
                currency: 'usd',
                current_amount: '',
                amount_needed: '',
                address_one: (this.user.address != null) ? this.user.address.address_one : '',
                address_two: (this.user.address != null) ? this.user.address.address_two : '',
                city: (this.user.address != null) ? this.user.address.city : '',
                post_code: (this.user.address != null) ? this.user.address.post_code : '',
                country: (this.user.address != null) ? this.user.address.country : '',
                allowed: this.user.donated,
                number_of_wishes: this.user.number_of_wishes,
                buffering: false,
                priority: this.user.priority,
                converted: ''
            }
        },
        methods: {
            postWish() {
                this.convertCurrency();
                this.buffering = true;
                axios.post('/wishes', this.$data)
                    .then(() => {
                        window.events.$emit('newWish', {
                            'amount_needed': this.converted[1],
                            'created_at': moment(),
                            'current_amount': this.converted[0],
                            'item': this.item
                        });

                        window.events.$emit('achievements', [this.amount, [3]]);

                        this.item = '';
                        this.url = '';
                        this.current_amount = '';
                        this.amount_needed = '';
                        this.number_of_wishes--;

                        if (this.priority > 0) {
                            this.priority--;
                        }

                        this.buffering = false;
                        let message = window.flashMessages[window.App.locale]['published-wish'];

                        flash([message]);
                    })
                    .catch((error) => {
                        let messages = [];
                        for (let key in error.response.data) {
                            messages.push(error.response.data[key][0]);
                        }

                        this.buffering = false;
                        flash(messages, 'error');
                    });
            },
            convertCurrency() {
                axios.get('/convert', {
                    params: {
                        currency: this.currency,
                        amount: [(this.current_amount != '') ? this.current_amount : 0, this.amount_needed]
                    }
                }).then(({data}) => {
                    this.converted = data;
                });
            }
        },
        created() {
            window.events.$on('decrement', () => {
                this.allowed = 1;
            });
            window.events.$on('moreWishes', (quantity) => {
                this.number_of_wishes += parseFloat(quantity);
            });

            if (this.last_currency != '') this.currency = this.last_currency;
        }
    }
</script>