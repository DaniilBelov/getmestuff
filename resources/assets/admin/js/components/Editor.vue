<template>
    <div class="custom panel panel-info" v-if="isEditing">
        <div class="panel-heading">
            <div class="panel-title">
                Edit Row
            </div>
            <span @click="closeEditor">&#10006;</span>
        </div>
        <div class="panel-body">
            <form id="form" @keydown.13="submitForm">
                <div v-for="(item, key) in items" v-if="skipTheseFields(key)">
                    <div class="form-group" v-if="checkFields(key)">
                        <label :for="key" v-text="formatString(key)"></label>
                        <input :name="key" class="form-control" v-model="items[key]" autocomplete="off">
                    </div>
                    <div class="form-group" v-else-if="!checkRadio(key)">
                        <label v-text="formatString(key)"></label>
                        <div>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-secondary" :class="{ active: item }" @click="items[key] = 1">
                                    <input type="radio" :name="key" value="1" :checked="item" v-model="items[key]">
                                    True
                                </label>
                                <label class="btn btn-secondary" :class="{ active: !item }" @click="items[key] = 0">
                                    <input type="radio" :name="key" value="0" :checked="!item" v-model="items[key]">
                                    False
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="address" v-else-if="checkIfObject(key)">
                        <div class="form-group" v-for="(data, name) in item">
                            <div v-if="!checkIfObject(data, true)">
                                <label :for="name" v-text="formatString(name)"></label>
                                <input :name="name"
                                       class="form-control"
                                       v-model="items[key][name]">
                            </div>
                            <div v-else>
                                <h4 v-text="name"></h4>
                                <div class="form-group" v-for="translation, label in data">
                                    <label :for="label" v-text="formatString(label)"></label>
                                    <input :name="label"
                                           class="form-control"
                                           v-model="items[key][name][label]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" v-else-if="!checkTextarea(key)">
                        <label :for="key" v-text="formatString(key)"></label>
                        <textarea :name="key" rows="2" class="form-control" v-model="items[key]"></textarea>
                    </div>
                    <div class="form-group" v-else-if="checkSelect(key)">
                        <label :for="key" v-text="formatString(key)"></label>
                        <select class="form-control" v-model="items[key]">
                            <option v-for="(slug, option) in select[key]"
                                    :selected="item == option"
                                    :value="option"
                                    v-text="slug"></option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel-footer"><button @click.prevent="submitForm" class="btn btn-primary">Submit</button></div>
    </div>
</template>
<script>
    export default {
        props: {
            isEditing: {
                default: false
            },
            dataSet: {
                default: false
            },
            url: {
                default: ''
            },
            radio: {
                default: () => {
                    return [];
                },
                required: false
            },
            skip: {
                default: () => {
                    return [];
                },
                required: false
            },
            textarea: {
                default: () => {
                    return [];
                },
                required: false
            },
            select: {
                default: () => {
                    return [];
                },
                required: false
            }
        },
        data() {
            return {
                items: this.dataSet,
            }
        },
        watch: {
            dataSet() {
                this.items = this.dataSet;
            }
        },
        methods: {
            formatString(str) {
                return str.replace(/_/g, ' ');
            },
            closeEditor() {
                this.$emit('cancel');
            },
            submitForm() {
                axios.patch(this.url +'/'+ this.dataSet.id, this.items).then(() => {
                    this.$emit('updated', this.items);
                    flash(['Row has been updated']);
                }).catch((error) => {
                    let messages = [];
                    for (let key in error.response.data) {
                        messages.push(error.response.data[key][0]);
                    }

                    this.buffering = false;
                    flash(messages, 'alert-danger');
                });
            },
            checkRadio(key) {
                return !(this.radio.indexOf(key) >= 0);
            },
            checkTextarea(key) {
                return !(this.textarea.indexOf(key) >= 0);
            },
            skipTheseFields(key) {
                return !(this.skip.indexOf(key) >= 0);
            },
            checkIfObject(key, second = false) {
                if (second) {
                    return (key !== null && typeof key === 'object');
                }
                return (this.items[key] !== null && typeof this.items[key] === 'object');
            },
            checkSelect(key) {
                return key in this.select;
            },
            checkFields(key) {
                return (this.checkRadio(key)
                        && !this.checkIfObject(key)
                        && this.checkTextarea(key)
                        && !this.checkSelect(key));
            },
        }
    }
</script>