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
        props: [ 'type', 'trigger', 'name', 'id', 'minlength', 'equalto', 'old' ],
        data() {
            return {
                hasValue: false
            }
        },
        mounted() {
            if (this.old != undefined && this.old != '') {
                document.querySelector(`#${this.id}`).value = this.old;
                this.hasValue = true;
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