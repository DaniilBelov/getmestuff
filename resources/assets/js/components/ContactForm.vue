<template>
    <form @keydown.13.prevent="send" class="vertical center mw" data-parsley-validate autocomplete="off">
        <div class="mw input-wrapper pos-r">
            <input type="email" v-model="email" name="email" :placeholder="$t('contact-email')" required>
        </div>
        <div class="mw input-wrapper pos-r">
            <input type="text" v-model="subject" name="subject" :placeholder="$t('subject')" required>
        </div>
        <div class="mw input-wrapper pos-r">
            <input type="text" v-model="organisation" name="organisation" :placeholder="$t('org')">
        </div>
        <div class="mw input-wrapper pos-r">
            <textarea name="message" v-model="body" :placeholder="$t('message')" required></textarea>
        </div>
        <button :disabled="buffering" @click.prevent="send" type="submit" class="pos-r">
            <i v-show="buffering" class="fa fa-refresh fa-spin pos-a fa-lg" aria-hidden="true"></i>
            {{ $t('send') }}
        </button>
    </form>
</template>
<script>
    export default {
        data() {
            return {
                email: '',
                subject: '',
                organisation: '',
                body: '',
                buffering: false,
            }
        },
        methods: {
            send() {
                this.buffering = true;
                axios.post('/tickets/new', this.$data)
                    .then(() => {
                        if (!window.App.signedIn) this.email = '';
                        this.subject = '';
                        this.body = '';

                        this.buffering = false;
                        let message = window.flashMessages[window.App.locale]['contact-message'];

                        flash([message]);
                    }).catch((error) => {
                        this.buffering = false;

                        let messages = [];
                        for (let key in error.response.data) {
                            messages.push(error.response.data[key][0]);
                        }

                        flash(messages, 'error');
                    });
            }
        },
        created() {
            if (window.App.signedIn) {
                this.email = window.App.user.email;
            }
        }
    }
</script>