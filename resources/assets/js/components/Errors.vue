<template>
    <div class="alert error dismissible" role="alert" v-show="show">
        <a class="close pos-a" data-dismiss="alert" @click.prevent="close"><span aria-hidden="true">&times;</span></a>
        <strong>Error!</strong>
        <ul>
            <li v-for="error in errors" v-text="error">Message 1</li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: ['errors'],
        data() {
            return {
                show: true,
            }
        },
        methods: {
            close() {
                this.show = false;
            }
        }
    }
</script>
