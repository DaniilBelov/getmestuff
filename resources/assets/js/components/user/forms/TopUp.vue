<template>
    <div>
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" id="paypal-payment" method="post" target="_top" v-if="locale == 'en'">
            <button :disabled="buffering" class="mw pos-r" @click.prevent="getFormData" type="submit">Top Up</button>
        </form>
        <form class="mw flex center" id="interkassa-payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8" v-else>
            <button :disabled="buffering" class="mw pos-r" @click.prevent="getFormData" type="submit">
                Поплнить кошелек
            </button>
    </form>
    </div>
    
</template>
<script>
    export default {
        props: ['amount'],

        data() {
            return {
                buffering: false,
                token: '',
                locale: window.App.locale,
                money: 0
            }
        },
        methods: {
            getFormData() {
                this.buffering = true;

                let id = this.locale == 'en' ? '#paypal-payment' : '#interkassa-payment';
                let url = this.locale == 'en' ? '/paypal' : '/interkassa';

                axios.get(url, {
                    params: {
                        amount: this.amount
                    }
                }).then(({data}) => {
                    for (let key in data) {
                        $("<input type='hidden' />")
                            .val(data[key])
                            .attr('name', key)
                            .appendTo(id);
                    }

                    $(id).submit();
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