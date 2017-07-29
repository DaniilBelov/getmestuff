<template>
    <div class="mw">
        <input 
            :class="{ hasvalue : hasValue }" 
            :data-parsley-trigger="trigger" 
            :data-parsley-equalto="equalto"
            @blur="checkInput($event)" 
            :minlength="minlength" 
            autocomplete="off" 
            :name="name" 
            :type="type" 
            :id="id" 
            required>
        <label class="animated"><slot></slot></label>
    </div>
</template>

<script>
    export default {
        props: [ 'type', 'trigger', 'name', 'id', 'minlength', 'equalto' ],
        data() {
            return {
                hasValue: false
            }
        },
        methods: {
            checkInput(event) {
                let value = event.currentTarget.value;
                if (value == '') {
                    this.hasValue = false;
                } else {
                    this.hasValue = true;
                }
            }
        }
    };
</script>