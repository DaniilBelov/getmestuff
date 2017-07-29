<template>
    <transition name="flash">
        <div class="alert" :class="classType" v-show="show">
            <div class="header mw">
                <strong v-text="$t(classType)"></strong>
                <a v-show="classType == 'error'" class="close pos-a" data-dismiss="alert" @click.prevent="show = false">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <ul>
                <li v-for="item in items" v-text="item"></li>
            </ul>
        </div>
    </transition>
</template>

<script>
    export default {
        props: ['message', 'error'],
        data() {
            return {
                type: 'Success',
                items: '',
                show: false,
                classType: 'success'
            }
        },
        created() {
            if (this.message[0] != null) {
                this.flash(this.message, 'success');
            } else if (this.error) {
                this.flash(this.error, 'error');
            }

            window.events.$on('flash', ([message, type]) => this.flash(message, type));
        },
        methods: {
            flash(messages, type = 'success') {
                this.items = messages;
                this.classType = type;
                this.show = true;

                if (type == 'success') this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },
            capitalize(str) {
                return str[0].toUpperCase() + str.slice(1).toLowerCase();
            }
        }
    };
</script>