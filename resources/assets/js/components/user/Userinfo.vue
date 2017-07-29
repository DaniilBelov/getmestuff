<template>
    <section class="mw flex between user-info">
        <div class="user-info-wrapper flex start">
            <p>{{ first_name + ' ' + last_name }}</p>
        </div>
        <p>{{ balance + '$'}}</p>
    </section>
</template>

<script>
    export default {
        props: ['user', 'notifications'],
        data() {
            return {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                balance: this.user.balance.toFixed(2),
            }
        },
        computed: {
            money() {
                return this.user.balance.toFixed(2);
            }
        },
        created() {
            window.events.$on('increment', (argument) => {
                this.balance += parseFloat(argument);
            });

            window.events.$on('decrement', (argument) => {
                console.log(parseFloat(argument));
                this.balance = (parseFloat(this.balance) - parseFloat(argument)).toFixed(2);
            });

            window.events.$on('profileUpdate', (argument) => {
                this.first_name = argument.first_name;
                this.last_name = argument.last_name;
            });
        }
    }
</script>