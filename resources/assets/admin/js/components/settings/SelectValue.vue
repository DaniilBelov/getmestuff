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
                <select class="form-control select2" v-model="value">
                    <option v-for="(option, type) in options" :value="type" v-text="option" :selected="type == value"></option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data', 'options'],
        data() {
            return {
                value: this.data.data.value,
                checkboxValue: this.data.data.on,
            }
        },
        mounted() {
            this.triggerTogler();

            let select = $('.select2').select2();

            select.trigger('change')
                .on('change', (event) => {
                    this.value = event.val;
                    this.changeValue();
                });
        },
        methods: {
            formatString(str) {
                return str.replace(/_/g, ' ');
            },
            triggerTogler() {
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
            changeValue() {
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
            },
        }
    }
</script>