<template>
    <div class="mw">
        <div class="sttabs tabs-style-bar">
            <nav>
                <ul class="">
                    <li v-for="tab in tabs"
                        :class="{ 'tab-current' : tab.isActive }"
                        @click="selectTab(tab)"
                        :title="tab.title"
                    >
                        <a v-html="tab.name"></a>
                    </li>
                </ul>
            </nav>
        </div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: ['form'],
        data() {
            return {
                tabs: []
            }
        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name);
                });
            }
        },
        created() {
            this.tabs = this.$children;
        },
        mounted() {
            if (this.form) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == this.form);
                });
            }
        }
    }
</script>