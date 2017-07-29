<template>
    <transition name="tab" v-if="transition">
        <div v-show="isActive">
            <slot></slot>
        </div>
    </transition>
    <div v-show="isActive" v-else>
            <slot></slot>
        </div>
</template>

<script>
    export default {
        props: {
            'name': {required: true},
            'selected': {default: false},
            'title': {default: ''},
            'form': {required: false},
            'transition': {default: true}
        },
        data() {
            return {
                isActive: false
            }
        },
        mounted() {
            this.isActive = this.selected;
        }
    }
</script>