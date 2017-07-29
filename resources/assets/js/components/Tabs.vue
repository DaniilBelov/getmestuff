<template>
    <div class="mw">
        <ul class="tabs">
            <li v-for="tab in tabs"
                :class="{ 'active' : tab.isActive }"
                @click="selectTab(tab)"
                :title="tab.title"
                v-html="tab.name">
            </li>
        </ul>
        <div class="sometimes">
            <slot></slot>
        </div>
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
                    tab.isActive = (tab.form == this.form);
                });
            }
        }
    }
</script>