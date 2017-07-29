<template>
    <div class="badge start-center mw pos-r">
        <div class="pos-r radial-wrapper">
            <svg width="65" height="65" class="pos-a">
                <circle v-show="has != need" :style="{ 'stroke-dasharray': svgDash + ' 103' }" r="16.25" cx="32.5" cy="32.5" class="pie"/>
            </svg>
            <img :src="image">
        </div>
        <div class="flex vertical badge-info">
            <div class="tool-tip">
                <h4 v-html="achievement.title + ' - ' + achievement.prize + ' ' + '<i class=\'fa fa-trophy currency\' aria-hidden=\'true\'></i>'"></h4>
                <p v-text="achievement.description + ' ' + '('+has+'/'+need+')'"></p>
            </div>
        </div>
        <i class="pos-a completed fa fa-check-circle" v-if="completed == 1" aria-hidden="true"></i>
    </div>
</template>
<script>
    export default {
        props: ['image', 'achievement', 'userinfo'],
        data() {
            return {
                has: '',
                need: this.achievement.need,
                completed: ''
            }
        },
        methods: {
            moreInfo() {
                this.tooltip = !this.tooltip;
            }
        },
        created() {
            for (let key in this.userinfo) {
                if (key == this.achievement.id) {
                    this.has = this.userinfo[key].has;
                    this.completed = this.userinfo[key].completed;
                }
            }
            window.events.$on('achievements', ([amount, type]) => {
                // console.log(type);
                this.recordAchievements(amount, type);
            });
        },
        computed: {
            percentComplete() {
                return Math.round(this.has / this.need * 100);
            },
            svgDash() {
                return (103 - Math.round(this.has * 103 / this.need));
            }
        },
        methods: {
            recordAchievements(amount, types) {
                types.forEach((type) => {
                    if (this.achievement.type == type) {
                        if (this.achievement.renew == 2) {
                            this.recordStaticAchievement(amount);
                            return;
                        } else {
                            this.recordOngoingAchievement(amount);
                        }
                    }
                });
            },
            recordStaticAchievement(amount) {
                if (this.achievement.need <= amount) {
                    this.completed = 1;
                    window.totalprize += parseFloat(this.achievement.prize);
                } else if (this.has < amount) {
                    this.has = parseFloat(amount);
                }
            },
            recordOngoingAchievement(amount) {
                if (this.completed == 1) {
                    return;
                } else if (this.achievement.need <= amount) {
                    this.has = this.achievement.need;
                    this.completed = 1;
                    window.totalprize += parseFloat(this.achievement.prize);
                } else {
                    this.has += parseFloat(amount);
                }
            }
        }
    }
</script>