<template>
    <div v-show="show">
        <div class="forgot-form pos-a" v-show="show">
            <a class="close pos-a" data-dismiss="alert" @click.prevent="close">
                <span aria-hidden="true">&times;</span>
            </a>
            <div class="mw pas-wrapper flex center pos-r">
                <form class="mw flex vertical nc-between" v-if="!isSent" autocomplete="off">
                    <label v-text="$t('your-email')"></label>
                    <div class="flex start">
                        <input id="email" name="email" type="email" v-model="email">
                        <button class="pos-r" :disabled="buffering" @click.prevent="sendData" type="submit">
                            <i v-show="buffering" class="fa fa-refresh fa-spin pos-a" aria-hidden="true"></i>
                            OK
                        </button>
                    </div>
                </form>
                <div class="done flex vertical center" v-else>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <p v-text="$t('check-inbox')"></p>
                </div>
            </div>
        </div>
        <div v-show="show" class="overlay pos-a mw mh"></div>
    </div>
</template>
<script>
    export default {
        props: ['visible', 'route'],
        data() {
            return {
                email: '',
                isSent: false,
                buffering: false,
                show: this.visible
            }
        },
        watch: {
            visible() {
                this.show = this.visible;
            }
        },
        methods: {
            sendData() {
                this.buffering = true;
                axios.post(this.route, {
                    email: this.email
                }).then(() => {
                    this.buffering = false;
                    this.isSent = true;

                    setTimeout(() => {
                        this.show = false;
                    }, 500)
                }).catch((error) => {
                    this.buffering = false;
                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key]);
                    }

                    this.buffering = false;
                    flash(messages, 'error');
                });
            },
            close() {
                this.$emit('close');
            }
        },
    }
</script>