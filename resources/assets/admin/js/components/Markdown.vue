<template>
    <div class="white-box">
        <textarea :id="name"></textarea>
        <button @click="savedocument" class="btn btn-outline-success" type="button">Save</button>
    </div>
</template>
<script>
    import simplemde from 'simplemde';
    export default {
        props: ['value', 'name', 'doc'],
        data() {
            return {
                editor: null
            }
        },
        mounted() {
            this.editor = new simplemde({
                element: document.getElementById(this.name),
                initialValue: this.value,
                spellChecker: false,
                toolbar: false
            });
        },
        methods: {
            savedocument() {
                axios.post('admin/api/docs', {
                    document: this.editor.value(),
                    lang: this.name,
                    type: this.doc
                }).then(() => {
                    flash(['Document has been updated']);
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
