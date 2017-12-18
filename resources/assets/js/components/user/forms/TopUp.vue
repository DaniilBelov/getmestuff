<template>
    <form class="mw flex around vertical" v-if="locale == 'en'">
        <div id="paypal-button"></div>
    </form>
    <form class="mw flex center" id="interkassa-payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8" v-else>
        <button :disabled="buffering" class="mw pos-r" @click.prevent="submitPayment" type="submit">
            Поплнить кошелек
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
                paypal.Button.render({
                    env: 'sandbox', // Or 'sandbox',
                    client: {
                        sandbox: 'AYK2wIbU-3bGn17T-A05XXGmGco2_zlOIiB_Yd9BN_F_0ZrvdMIEUR4rQYy9SPPgXY4Z-kQ7Yy77eVXO'
                    },
                    commit: true, // Show a 'Pay Now' button
                    style: {
                        color: 'gold',
                        size: 'small'
                    },
                    payment: function(data, actions) {
                        return actions.payment.create({
                            payment: {
                                transactions: [
                                    {
                                        amount: { total: '1.00', currency: 'USD' }
                                    }
                                ]
                            }
                        });
                    },
                    onAuthorize: function(data, actions) {
                        return actions.payment.execute().then(function(payment) {
                            if (payment.state == "approved") {
                                let amount = payment.transactions[0].amount.total;
                                console.log(amount);
                            }
                        });
                    },
                    onError: function(err) {
                        console.log(err);
                    }}, '#paypal-button');
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