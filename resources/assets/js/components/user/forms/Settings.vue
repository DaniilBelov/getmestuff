<template>
    <section class="flex vertical start bg-white main-section" id="settings">
        <h2>{{ $t('edit') }}</h2>
        <form class="mw vertical center" action="/home/update" method="POST" data-parsley-validate>
            <div class="mw">
                <div class="mw pos-r">
                    <input type="text"
                           id="first_name"
                           name="first_name"
                           :placeholder="$t('first_name')"
                           v-model="first_name"
                           autocomplete="off">
                </div>
                <div class="mw pos-r">
                    <input type="text"
                           id="last_name"
                           name="last_name"
                           :placeholder="$t('last_name')"
                           v-model="last_name"
                           autocomplete="off">
                </div>
                <div class="mw pos-r">
                    <input data-parsley-trigger="change"
                           type="email"
                           id="email"
                           name="email"
                           :placeholder="$t('email')"
                           v-model="email"
                           autocomplete="off">
                </div>
                <div class="mw pos-r">
                    <input data-parsley-trigger="change"
                           minlength="1"
                           type="password"
                           id="password"
                           name="password"
                           v-model="password"
                           :placeholder="$t('edit_password')">
                </div>
            </div>
            <div class="divisor divisor-bg mw">
                <p><i class="fa fa-key" aria-hidden="true"></i><span>{{ $t('confirm') }}:</span></p>
                <div class="mw pos-r">
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           :placeholder="$t('current_password')"
                           v-model="current_password"
                           autocomplete="off" required>
                </div>
            </div>
            <div class="self-start">
                <button class="pos-r" :disabled="buffering" @click.prevent="updateSettings" type="submit">
                    <i v-show="buffering" class="fa fa-cog fa-spin fa-lg" aria-hidden="true"></i>
                    {{ $t('save') }}
                </button>
            </div>
        </form>
    </section>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                email: this.user.email,
                password: '',
                current_password: '',
                buffering: false
            }
        },
        methods: {
            updateSettings() {
                this.buffering = true;

                axios.patch('/home/update', this.$data)
                    .then(() => {
                        this.password = '';
                        this.current_password = '';

                        let messages = [window.flashMessages[window.App.locale]['profile-updated']];

                        if ((this.email != this.user.email) && (this.email != '')) {
                            this.email = this.user.email;
                            messages.push(window.flashMessages[window.App.locale]['verify-email']);
                        }

                        window.events.$emit('profileUpdate', {
                            'first_name': this.first_name,
                            'last_name': this.last_name
                        });

                        this.buffering = false;

                        flash(messages);
                    })
                    .catch((error) => {
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