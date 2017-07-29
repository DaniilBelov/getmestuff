<template>
    <form class="mw flex around vertical" v-if="locale == 'en'">
        <div class="w95 topup-form" id="dropin-container"></div>
        <div class="w95 flex start topup-button">
            <button :disabled="buffering" type="submit">{{ $t('top-up') }}</button>
        </div>
    </form>
    <form class="mw flex center" id="interkassa-payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8" v-else>
        <button :disabled="buffering" class="w95 pos-r" @click.prevent="submitPayment" type="submit">
            Поплнить
        </button>
    </form>
</template>
<script>
    export default {
        props: ['amount', 'user', 'commissions'],

        data() {
            return {
                buffering: false,
                token: '',
                locale: ''
            }
        },

        created() {
            this.locale = window.App.locale;

            if (this.locale == 'en') {
                axios.get('/braintree/token')
                    .then((response) => {
                        this.token = response.data.token;

                        braintree.setup(this.token, 'dropin', {
                            container: 'dropin-container',
                            onPaymentMethodReceived: (response) => {
                                this.buffering = true;

                                axios.post('/topup', {
                                    value: this.amount,
                                    braintreeNonce: response.nonce
                                }).then(() => {
                                    window.events.$emit('increment', this.amount);
                                    this.buffering = false;

                                    let message = window.flashMessages[window.App.locale]['redeemed'];

                                    flash([message]);
                                }).catch((error) => {
                                    let messages = [];
                                    for (let key in error.response.data) {
                                        messages.push(error.response.data[key][0]);
                                    }
                                    this.buffering = false;

                                    flash(messages, 'error');
                                });
                            }
                        });
                    });
            }
        },
        methods: {
            submitPayment() {
                this.buffering = true;
                axios.get('/interkassa', {
                    params: {
                        amount: this.amount
                    }
                }).then(({data}) => {
                    for (let key in data) {
                        $("<input type='hidden' />")
                            .val(data[key])
                            .attr('name', key)
                            .appendTo('#interkassa-payment');
                    }

                    $('#interkassa-payment').submit();
                }).catch((error) => {
                    this.buffering = true;

                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key][0]);
                    }
                    this.buffering = false;

                    flash(messages, 'error');
                });
            }
        }
    }
</script>