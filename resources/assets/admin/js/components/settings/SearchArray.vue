<template>
    <div class="white-box">
        <form class="form" @keydown.prevent.13="searchArray">
            <div class="form-group">
                <label class="control-label" v-text="formatString(data.setting)"></label>
                <div class="input-group">
                    <input @blur="checkItems" v-model="searchItem" type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn" v-show="add">
                        <button @click.prevent="addItem" class="btn btn-success">Add</button>
                    </span>
                </div>
            </div>
        </form>
        <div class="flex start wrap search-list">
            <span v-for="(item, key) in items" class="item label label-info flex between" :key="key">
                <span v-text="item"></span>
                <span @click="deleteItem(item, key)" class="delete">&#10006;</span>
            </span>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data'],
        data() {
            return {
                searchItem: '',
                items: false,
                add: false
            }
        },
        methods: {
            formatString(str) {
                return str.replace(/_/g, ' ');
            },
            searchArray() {
                if (this.searchItem != '') {
                    axios.post('/admin/api/search/'+this.data.id, {
                        search: this.searchItem
                    }).then(({data}) => {
                        if (data.length > 0) {
                            this.items = data;
                            this.add = false;
                        } else {
                            this.add = true;
                            this.items = false;
                        }
                    });
                } else {
                    this.items = false;
                    this.add = false;
                }
            },
            deleteItem(item, key) {
                if (confirm('Are you sure you want to delete this item?')) {
                    axios.delete('/admin/api/search/'+this.data.id, {
                        params: {
                            item: item
                        }
                    }).then(() => {
                        this.items.splice(key, 1);
                        if (this.items.length == 0) {
                            this.searchItem = '';
                        }
                        flash(['Item has been deleted']);
                    }).catch((error) => {
                        let messages = [];
                        for (let key in error.response.data) {
                            messages.push(error.response.data[key][0]);
                        }

                        this.buffering = false;
                        flash(messages, 'alert-danger');
                    });
                }
            },
            checkItems() {
                if (this.searchItem == '') {
                    this.items = false;
                    this.add = false;
                }
            },
            addItem() {
                if (confirm('Are you sure you want to add this item?')) {
                    axios.patch('/admin/api/search/'+this.data.id, {
                        item: this.searchItem
                    }).then(() => {
                        this.items = [this.searchItem];
                        this.add = false;
                        flash(['Item has been added']);
                    }).catch((error) => {
                        let messages = [];
                        for (let key in error.response.data) {
                            messages.push(error.response.data[key][0]);
                        }

                        this.buffering = false;
                        flash(messages, 'alert-danger');
                    });
                }
            }
        }
    }
</script>