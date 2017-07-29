<template>
    <section class="flex vertical start bg-white main-section" id="money">
        <h2 v-text="$t('wallet')"></h2>
        <div class="mw" v-if="disabled.on">
            <div class="flex between select">
                <form class="pos-r w48 m-auto">
                    <input :placeholder="$t('amount')" v-model="amount" @blur="twoDeciamls">
                    <i class="icn-pos fa fa-usd" aria-hidden="true"></i>
                </form>
                <div class="w48 m-auto">
                    <input class="m-auto p-none" :value="amountWithInterest" type="text" :placeholder="$t('interest')" disabled>
                </div>
            </div>
            <topup v-show="current == 'credit'" :user="user" :amount="amount"></topup>
        </div>
        <div class="empty mw" v-else>
            <p class="mw t-align" v-text="$t('disabled')"></p>
            <p class="mw t-align" v-text="$t('reason') +': '+ message"></p>
        </div>
    </section>
</template>

<script>
    import Topup from './forms/TopUp.vue';

    export default {
        components: { Topup },
        props: ['user', 'disabled', 'commissions'],
        data() {
            return {
                visible: '<i class="fa fa-credit-card" aria-hidden="true"></i> Credit Card',
                current: 'credit',
                amount: '',
                message: '',
            }
        },
        computed: {
            amountWithInterest() {
                if (this.amount == '') return;
                else if (window.App.locale == 'en') {
                    let commission = (1 + this.commissions.value.BrainTree / 100);
                    return (this.amount * commission).toFixed(2);
                } else {
                    let commission = (1 + this.commissions.value.INTERKASSA / 100);
                    return (this.amount * commission).toFixed(2);
                }
            }
        },
        methods: {
            selectDropdown(option, event) {
                this.visible = event.currentTarget.innerHTML;
                this.current = option;
                return;
            },
            twoDeciamls() {
                if (this.amount == '') return;
                let temp = this.amount;
                temp = (temp * 1).toFixed(2);
                this.amount = temp;
                return;
            }
        },
        mounted() {
            if (!this.disabled.on) {
                this.message = window.flashMessages[window.App.locale].construction[this.disabled.value];
            }
        }
    }
</script>