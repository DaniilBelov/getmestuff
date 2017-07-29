<template>
    <div class="row">
        <reply v-for="(ticket, key) in tickets"
               :data="ticket"
               :answer="checkIfAnswer(key)"
               :key="ticket.id"
               :user="user"></reply>
    </div>
</template>
<script>
    import Reply from './Reply.vue';
    export default {
        components: { Reply },
        props: ['tickets', 'user'],
        methods: {
            checkIfAnswer(key) {
                return (
                    (this.tickets.length - 1) == key) &&
                    this.tickets[key].reply == null &&
                    !this.tickets[key].is_admin;
            }
        }
    }
</script>