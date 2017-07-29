<template>
    <div class="white-box">
        <div class="form-group">
            <label class="control-label" v-text="formatString(data.setting)">Notify about donations above</label>
            <input v-if="data.data.checkbox"
                   type="checkbox"
                   class="js-switch"
                   :checked="checkboxValue"
            />
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-font"></i></span>
                <input @keydown.13="enterChangeValue" type="text" class="form-control" placeholder="Reason" v-model="value" aria-describedby="basic-addon1">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data'],
        data() {
            return {
                value: this.data.data.value,
                checkboxValue: this.data.data.on,
            }
        },
        mounted() {
            if (this.data.data.checkbox) {
                let elem = this.$el.querySelector('.js-switch');
                let init = new Switchery(elem, {
                    color: "#99d683",
                    size: "small",
                    disabled: false
                });

                this.$el.querySelector('.switchery').onclick = () => {
                    this.checkboxValue = elem.checked;
                    this.switcher();
                }
            }
        },
        methods: {
            formatString(str) {
                return str.replace(/_/g, ' ');
            },
            switcher() {
                axios.patch('/admin/api/settings/switch/'+this.data.id, {
                    state: this.checkboxValue
                }).then(() => {
                    flash(['Information has been updated']);
                }).catch((error) => {
                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key][0]);
                    }

                    this.buffering = false;
                    flash(messages, 'alert-danger');
                });;
            },
            enterChangeValue() {
                axios.patch('/admin/api/settings/'+this.data.id, {
                    value: this.value
                }).then(() => {
                    flash(['Information has been updated']);
                }).catch((error) => {
                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key][0]);
                    }

                    this.buffering = false;
                    flash(messages, 'alert-danger');
                });;
            }
        }
    }
</script>