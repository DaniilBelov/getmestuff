<template>
    <div class="wish mw">
        <slot name="header"></slot>
        <div class="content">
            <div class="header">
                <h4 v-text="data.item"></h4>
                <a v-if="report" @click="reportWish" :class="{ disabled: this.wait }" v-text="$t('report')"></a>
                <p v-else v-text="when"></p>
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
                <form v-if="displayForm">
                    <input type="text" name="amount" v-model="amount" required>
                    <button :disabled="this.wait" type="submit" class="pos-r" @click.prevent="donate">
                        <i v-show="buffering" class="fa fa-refresh fa-spin pos-a" aria-hidden="true"></i>
                        {{ $t('donate') }}
                    </button>
                </form>
                <a class="delete" @click="deleteWish" v-else>Delete</a>
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';

    export default {
        props: {
            data: { required: true },
            wait: { default: false },
            report: { default: true },
            displayForm: { default: true },
        },
        data() {
            return {
                id: this.data.id,
                amount: '',
                current: this.data.current_amount.toFixed(2),
                needed: this.data.amount_needed,
                buffering: false,
            }
        },
        computed: {
            when() {
                let date = moment.utc(this.data.created_at);
                let localDate = moment(date).local();
                return localDate.fromNow();
            },
            currentShrt() {
                return window.shortenNum(this.data.current_amount);
            },
            neededShrt() {
                return window.shortenNum(this.data.amount_needed);
            }
        },
        methods: {
            donate() {
                this.$emit('disable');
                this.buffering = true;

                axios.patch('/wish/'+this.id+'/donate', {
                    'amount': this.amount
                }).then(() => {
                    window.events.$emit('decrement', this.amount);
                    window.events.$emit('achievements', [this.amount, [1, 4]]);

                    this.current = (parseFloat(this.current) + parseFloat(this.amount)).toFixed(2);

                    this.$emit('donated', this.id);

                    let message = window.flashMessages[window.App.locale]['for-donating'];
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