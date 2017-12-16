<template>
    <div class="wish mw">
        <slot name="header"></slot>
        <div class="content">
            <div class="header">
                <h4 v-text="data.item"></h4>
                <a v-if="report" @click="reportWish" :class="{ disabled: this.wait }" v-text="$t('report')"></a>
                <a class="delete" @click="deleteWish" v-else>Delete</a>
            </div>
            <div class="progress">
                <p v-text="$t('progress')"></p>
                <div class="progress-bar">
                    <div :style="{width: (current/needed * 100) + '%'}"></div>
                </div>
            </div>
            <div class="footer">
                <p :title="current + '/' + needed">
                    {{ $t('collected') }}: {{ currentShrt }}/{{ neededShrt }}
                </p>
                <form>
                    <input type="text" name="amount" v-model="amount">
                    <button :disabled="this.wait" type="submit" class="pos-r" @click.prevent="donate">
                        <i v-show="buffering" class="fa fa-refresh fa-spin pos-a" aria-hidden="true"></i>
                        {{ $t('donate') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            data: { required: true },
            wait: { default: false },
            report: { default: true },
        },
        data() {
            return {
                id: this.data.id,
                amount: '',
                needed: this.data.amount_needed,
                current: this.data.current_amount,
                buffering: false,
            }
        },
        computed: {
            currentShrt() {
                return window.shortenNum(this.current);
            },
            neededShrt() {
                return window.shortenNum(this.needed);
            }
        },
        methods: {
            donate() {
                this.$emit('disable');
                this.buffering = true;

                axios.patch('/wish/'+this.id+'/donate', {
                    'amount': this.amount
                }).then(() => {
                    let message = window.flashMessages[window.App.locale]['donated'];

                    this.buffering = false;
                    console.log((parseFloat(this.current) + parseFloat(this.amount)).toFixed(2));
                    this.current = (parseFloat(this.current) + parseFloat(this.amount)).toFixed(2);

                    window.events.$emit('decrement', this.amount);

                    if (window.App.user.id != this.data.user_id) {
                        window.events.$emit('achievements', [this.amount, [1, 4]]);
                        message = window.flashMessages[window.App.locale]['for-donating'];
                    }

                    this.$emit('donated', this.id);
                    this.amount = '';

                    flash([message]);
                })
                .catch((error) => {
                    this.buffering = false;
                    this.$emit('enable');

                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key][0]);
                    }
                    flash(messages, 'error');
                });
            },
            reportWish() {
                this.$emit('disable');

                axios.patch('wish/'+this.id+'/report')
                    .then(() => {
                        this.$emit('donated', this.id);
                        let message = window.flashMessages[window.App.locale]['for-reporting'];

                        flash([message]);
                    })
                    .catch((error) => {
                        let message = window.flashMessages[window.App.locale]['for-reporting-fails'];
                        flash([message], 'error');
                    });
            },
            deleteWish() {
                axios.delete('wish/'+this.id)
                    .then(() => {
                        this.$emit('delete', this.id);
                        let message = window.flashMessages[window.App.locale]['deleting'];

                        flash([message]);
                    })
                    .catch((error) => {
                        let messages = [];
                        for (let key in error.response.data) {
                            messages.push(error.response.data[key][0]);
                        }
                        flash(messages, 'error');
                    });
            }
        }
    }
</script>