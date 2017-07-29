<script>
    import Animated from './Animated.vue';
    import ForgotPassword from './ForgotPassword.vue'
    export default {
        components: { Animated, ForgotPassword },
        data() {
            return {
                visible: false
            }
        },
        methods: {
            showForm() {
                this.visible = !this.visible;
            }
        }
    }
</script>