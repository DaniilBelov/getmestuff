<template>
    <div>
        <div v-for="(item, key) in data" class="row">
            <div class="col-md-12 col-xs-12"
                 v-if="key == 'together'">
                <div class="white-box">
                    <div class="row" v-for="input in item">
                        <div class="form-group" v-if="!input.lang">
                            <label class="control-label" v-text="makeUpper(input.name)"></label>
                            <div class="input-group" v-if="input.type == 'text'">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control"
                                       :placeholder="makeUpper(input.name)"
                                       v-model="values[input.name]">
                            </div>
                            <select class="form-control" v-if="input.type == 'select'" v-model="values[input.name]">
                                <option v-for="(value, option) in input.options"
                                        :value="value"
                                        v-text="makeUpper(option)"></option>
                            </select>
                            <input type="number" class="form-control" v-model="values[input.name]" v-if="input.type == 'number'">
                            <div class="input-group" v-if="input.type == 'textarea'">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <textarea class="form-control"
                                          :placeholder="makeUpper(input.name)"
                                          v-model="values[input.name]"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-6" v-for="lang in langs" v-else-if="input.lang">
                            <label class="control-label" v-text="makeUpper(input.name)"></label>
                            <div class="input-group" v-if="input.type == 'text'">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control"
                                       :placeholder="makeUpper(input.name) + ' - '+lang"
                                       v-model="values[lang][input.name]">
                            </div>
                            <div class="input-group" v-if="input.type == 'textarea'">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <textarea class="form-control"
                                          :placeholder="makeUpper(input.name) + ' - '+lang"
                                          v-model="values[lang][input.name]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12"
                 v-for="input in item"
                 :class="{'col-md-6': key == 'line', 'col-md-12': key != 'line'}"
                 v-if="key != 'together'">
                <div class="white-box">
                    <div class="form-group">
                        <label class="control-label" v-text="makeUpper(input.name)"></label>
                        <div class="input-group" v-if="input.type == 'text'">
                            <span class="input-group-addon"><i class="fa fa-font"></i></span>
                            <input type="text" class="form-control"
                                   :placeholder="makeUpper(input.name)"
                                   v-model="values[input.name]">
                        </div>
                        <select class="form-control" v-if="input.type == 'select'" v-model="values[input.name]">
                            <option v-for="(value, option) in input.options"
                                    :value="value"
                                    v-text="makeUpper(option)"></option>
                        </select>
                        <input type="number" class="form-control" v-model="values[input.name]" v-if="input.type == 'number'">
                        <div class="input-group" v-if="input.type == 'textarea'">
                            <span class="input-group-addon"><i class="fa fa-font"></i></span>
                            <textarea class="form-control"
                                      :placeholder="makeUpper(input.name)"
                                      v-model="values[input.name]"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 flex start">
                <button @click="submitForm" class="btn btn-outline-success btn-lg">Create</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['post', 'data'],
        data() {
            return {
                values: {
                    en: {},
                    ru: {}
                },
                langs: ['en', 'ru']
            }
        },
        created() {
            for (let item in this.data) {
                this.makeModel(this.data[item]);
            }
        },
        methods: {
            makeModel(item) {
                for (let input in item) {
                    if (item[input].type == 'number' || item[input].type == 'select') {
                        this.values[item[input].name] = 0;
                    }
                }
            },
            submitForm() {
                axios.post(this.post, this.values)
                    .then(() => {
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
            makeUpper(str) {
                let string =  str.charAt(0).toUpperCase() + str.slice(1);
                return string.replace(/_/g, ' ');
            }
        }
    }
</script>