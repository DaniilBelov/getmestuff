<script>
    export default {
        data() {
            return {
                show: false,
                color: '#000',
                unreadNotifications: false,
                unreadCount: ''
            }
        },
        methods: {
            toggle() {
                if (this.show) {
                    this.color = 'black';
                    this.show = false;
                } else {
                    this.color = '#FFF';
                    this.show = true;
                }
            },
            fetch(page) {
                axios.get('/unread').then(({data}) => {
                    this.unreadNotifications = (data.length > 0);
                    this.unreadCount = data.length;
                }).catch(() => {
                    return;
                });
            }
        }
    }
</script>