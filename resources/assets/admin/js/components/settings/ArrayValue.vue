<template>
    <div>
        <div class="col-xs-6 col-md-6" v-for="(item, key) in data.data.value">
            <div class="white-box" v-if="text">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa" :class="icons[key]"></i></span>
                    <input @keydown.13="sendValue(key)" type="text" class="form-control" v-model="value[key]"/>
                </div>
            </div>
            <div class="white-box" v-else>
                <div class="form-group">
                    <label class="control-label" v-text="formatString(key)">Notify about donations above</label>
                    <div class="input-group">
                    <span class="input-group-btn">
                        <button @click="changeValue(true, key)" class="btn btn-default btn-outline" type="button">-</button>
                    </span>
                        <input type="text" class="form-control" v-model="value[key]" @keydown.13="sendValue(key)">
                    <span class="input-group-btn">
                        <button @click="changeValue(false, key)" class="btn btn-default btn-outline" type="button">+</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data', 'icons', 'text'],
        data() {
            return {
                value: this.data.data.value,
                timeout: null
            }
        },
        methods: {
            sendValue(key) {
                axios.patch('/admin/api/settings/'+this.data.id, {
                    value: this.value[key],
                    key: key
                }).then(() => {
                    flash(['Information has been updated']);
                }).catch((error) => {
                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key][0]);
                    }

                    this.buffering = false;
                    flash(messages, 'alert-danger');
                });
            },
            formatString(str) {
                return str.replace(/_/g, ' ');
            },
            changeValue(decrementValue, key) {
                if (decrementValue) {
                    if (this.value[key] > 1) this.value[key]--;
                } else {
                    this.value[key]++;
                }

                clearTimeout(this.timeout);

                this.timeout = setTimeout(() => {
                    this.sendValue(key);
                }, 800);
            },
        }
    }
</script>