<template>
    <div class="social-links flex center vertical mw">
        <div class="fb-page margin-social"
             data-href="https://www.facebook.com/GetMeStuffOfficial"
             data-tabs="timeline"
             data-small-header="false"
             data-width="320"
             data-hide-cover="false"
             data-show-facepile="true"
             data-show-posts="false"
             v-if="locale">
            <blockquote cite="https://www.facebook.com/GetMeStuffOfficial" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/GetMeStuffOfficial">Get Me Stuff</a>
            </blockquote>
        </div>
        <div class="margin-social mw" id="vk_groups" v-else></div>
        <a class="twitter-timeline"
           data-height="300"
           data-theme="light"
           href="https://twitter.com/RealGetMeStuff">
            Tweets by RealGetMeStuff</a>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                locale: (window.App.locale == 'en')
            }
        },
        mounted() {
            VK.init({
                apiId: 6112127,
                onlyWidgets: true,
            });

            if (!this.locale) VK.Widgets.Group("vk_groups", {mode: 3, width: 'auto'}, 149608803);

            VK.Observer.subscribe('widgets.groups.joined', () => {
                this.recordAchievement();
            });

            window.fbAsyncInit = () => {
                FB.init({
                    appId            : '207139529816294',
                    autoLogAppEvents : true,
                    xfbml            : true,
                    version          : 'v2.9'
                });
                FB.AppEvents.logPageView();

                FB.Event.subscribe('edge.create', () => {
                    this.recordAchievement();
                });
            };
        },
        methods: {
            recordAchievement() {
                axios.get('/subscribe');
            }
        }
    }
</script>