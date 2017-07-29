<template>
    <div>
        <editor :isEditing="editing"
                :dataSet="tableData"
                :url="post"
                :radio="radio"
                :skip="skip"
                :textarea="textarea"
                :select="select"
                @updated="updateRow"
                @cancel="closeEditor"></editor>
        <div class="">
            <button class="btn btn-warning" :disabled="!anySelected" @click="answerTicket" v-if="answer">Answer</button>
            <button class="btn btn-info" :disabled="!anySelected" @click="editRow">Edit</button>
            <button class="btn btn-danger" :disabled="!anySelected" @click="deleteRow">Delete</button>
        </div>
        <table id="table" class="table table-bordered">
            <thead>
                <slot name="header"></slot>
            </thead>
        </table>
    </div>
</template>
<script>
    import Editor from './Editor.vue';

    export default {
        components: { Editor },
        props: {
            get: {
                defualt: '',
                required: true
            },
            post: {
                defualt: '',
                reuired: true
            },
            columns: {
                defualt: () => {
                    return [];
                },
                reqired: true
            },
            checkboxes: {
                default: () => {
                    return [];
                },
                required: false
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
                defualt: () => {
                    return [];
                },
                required: false
            },
            select: {
                defualt: () => {
                    return [];
                },
                required: false
            },
            answer: {
                default: false,
                required: false
            }
        },
        data() {
            return {
                items: false,
                dataSet: false,
                table: '',
                tableData: false,
                anySelected: false,
                editing: false,
                renderColumns: []
            }
        },
        created() {
            this.columns.forEach((value) => {
                if (this.checkboxes.indexOf(value.data) >= 0) {
                    value.render = (data) => {
                        return this.checkbox(data);
                    };
                }
                this.renderColumns.push(value);
            });
        },
        mounted() {
            this.createTable();
        },
        methods: {
            createTable() {
                 this.table = $('#table').DataTable({
                     processing: true,
                     serverSide: true,
                     lengthChange: false,
                     ajax: this.get,
                     rowId: 'id',
                     colReorder: true,
                     columns: this.renderColumns,
                     select: true,
                 });

                 this.table.on('select', () => {
                     this.anySelected = true;
                 });

                this.table.on('deselect', () => {
                    this.anySelected = false;
                });
            },
            editRow() {
                this.tableData = this.table.row({selected: true}).data();
                this.editing = true;
            },
            updateRow(payload) {
                this.editing = false;
                this.table.row({rowId:payload.id}).data(payload).draw();
                this.anySelected = false;
            },
            closeEditor() {
                this.editing = false;
            },
            deleteRow() {
                let id = this.table.row({selected:true}).id();
                if (confirm('Are you sure you want to delete this row?')) {
                    axios.delete(this.post+'/'+id).then(() => {
                        this.table.row({rowId:id}).remove().draw();
                        this.anySelected = false;
                    }).then(() => {
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
            checkbox(data) {
                if (data == 0) {
                    return "<input type='checkbox' class='gms-checkbox' disabled/>";
                } else {
                    return "<input type='checkbox' class='gms-checkbox' checked disabled/>";
                }
            },
            answerTicket() {
                let data = this.table.row({selected:true}).data();
                if (data.type != 2) {
                    window.location.href = ('/admin/tickets/'+data.unique_id);
                }
            }
        }
    }
</script>