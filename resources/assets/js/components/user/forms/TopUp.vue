<template>
    <div>
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top" v-if="locale == 'en'">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="amount" value="20">
            <input type="hidden" name="business" value="getmestuff.business-facilitator@gmail.com">
            <!-- <input type="hidden" name="notify_url" value="http://a2ea6c3f.ngrok.io/en/paypal/success"> -->
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="custom" :value="user">
            <input type="hidden" name="return" value="http://a2ea6c3f.ngrok.io/home">
            <input type="hidden" name="item_name" value="GetMeStuff | Account Top Up">
            <!-- <input type="hidden" name="hosted_button_id" value="PDB4GXHVUM4WQ"> -->
            <button type="submit">Top Up</button>
        </form>
        <form class="mw flex center" id="interkassa-payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8" v-else>
            <button :disabled="buffering" class="mw pos-r" @click.prevent="submitPayment" type="submit">
                Поплнить кошелек
            </button>
    </form>
    </div>
    
</template>
<script>
    export default {
        props: ['amount', 'user', 'commissions'],

        data() {
            return {
                buffering: false,
                token: '',
                locale: '',
                money: 0
            }
        },
        watch: {
            amount(val) {
                this.moeny = +val;
            }
        },
        created() {
            this.locale = window.App.locale;

            // if (this.locale == 'en') {
            //     let CREATE_PAYMENT_URL  = `http://getmestuff.dev/en/paypal/create-payment`;
            //     let EXECUTE_PAYMENT_URL = 'http://getmestuff.dev/en/paypal/execute-payment';

            //     paypal.Button.render({
            //         env: 'sandbox',
            //         client: {
            //             sandbox: 'AYK2wIbU-3bGn17T-A05XXGmGco2_zlOIiB_Yd9BN_F_0ZrvdMIEUR4rQYy9SPPgXY4Z-kQ7Yy77eVXO'
            //         },
            //         commit: true,
            //         style: {
            //             color: 'gold',
            //             size: 'small'
            //         },
            //         payment: function(data, actions) {
            //             return axios.post(CREATE_PAYMENT_URL, {
            //                 amount: this.amount
            //             }).then((data) => {
            //                 return data.id;
            //             });
            //             // return paypal.request.post(CREATE_PAYMENT_URL).then(function(data) {
            //             //     return data.id;
            //             // });
            //             // return actions.payment.create({
            //             //     payment: {
            //             //         transactions: [
            //             //             {
            //             //                 amount: { total: '1.00', currency: 'USD' }
            //             //             }
            //             //         ]
            //             //     }
            //             // });
            //         },
            //         onAuthorize: function(data, actions) {
            //             return actions.payment.execute().then(function(payment) {
            //                 if (payment.state == "approved") {
            //                     let amount = payment.transactions[0].amount.total;
            //                     console.log(amount);
            //                 }
            //             });
            //         },
            //         onError: function(err) {
            //             console.log(err);
            //         }}, '#paypal-button');
            // }
        },
        computed: {
            user() {
                return window.App.user.id;
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