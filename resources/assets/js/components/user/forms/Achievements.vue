<script>
    import Badge from '../Badge.vue';
    import Redeem from './Redeem.vue'

    import countTo from 'jquery-countto';

    export default {
        components: { Badge, Redeem },
        props: ['user'],
        data() {
            return {
                points: this.user.points,
                donated: this.user.amount_donated,
                expanded: false,
                currentText: 'redeem'
            }
        },
        created() {
            window.events.$on('achievements', (amount) => {
                setTimeout(() => {
                    $('#points-number').countTo({
                        from: this.points,
                        to: this.points + window.totalprize,
                        onComplete: () => {
                            this.points += window.totalprize;
                            window.totalprize = 0;
                        }
                    });

                    this.donated += parseFloat(amount);
                }, 1);
            });

            window.events.$on('pointsDown', (amount) => {
                this.points -= parseFloat(amount);
            })
        },
        methods: {
            changeClass() {
                if (!this.expanded) {
                    this.expanded = true;
                    this.currentText = 'not-redeem';
                } else {
                    this.expanded = false;
                    this.currentText = 'redeem';
                }
            }
        },
        computed: {
            donatedShrt() {
                return window.shortenNum(this.donated);
            }
        }
    }
</script>