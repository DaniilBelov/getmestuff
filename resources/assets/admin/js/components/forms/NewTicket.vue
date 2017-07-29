<template>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <select name="users" class="form-control" id="users" multiple="multiple" data-placeholder="Select Users"></select>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <select name="priority" class="form-control select2 single" data-placeholder="Select importance status">
                    <option value="0" selected>Green</option>
                    <option value="1">Yellow</option>
                    <option value="2">Red</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-font"></i></span>
                        <input name="subject" v-model="subject" type="text" class="form-control" placeholder="Subject">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <textarea v-model="body" id="mymce" name="area"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <button @click="sendContent" class="fcbtn btn btn-lg btn-outline btn-success btn-1d waves-effect waves-light pull-right"><i class="fa fa-paper-plane-o"></i> SEND</button>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                users: [],
                priority: 0,
                subject: '',
                body: ''
            }
        },
        created() {
            window.events.$on('input', () => {
                console.log('hi');
            });
        },
        mounted() {
            this.initTinyMCE();

            $(document).ready(() => {
                $('.select2').select2({
                    theme: "bootstrap"
                }).trigger('change')
                    .on('change', (event) => {
                        this[event.currentTarget.name] = event.currentTarget.value;
                    });

                $('#users').select2({
                    theme: "bootstrap",
                    ajax : {
                        url : '/admin/api/users/emails',
                        dataType : 'json',
                        delay : 200,
                        data : function(params){
                            return {
                                q : params.term,
                                page : params.page
                            };
                        },
                        processResults : function(data, params){
                            params.page = params.page || 1;
                            return {
                                results : data.data,
                                pagination: {
                                    more : (params.page  * 10) < data.total
                                }
                            };
                        }
                    },
                    minimumInputLength : 1,
                    templateResult : function (repo){
                        if(repo.loading) return repo.email;
                        return repo.email;
                    },
                    templateSelection : function(repo, d)
                    {
                        return repo.email;
                    },
                    escapeMarkup : function(markup){ return markup; }
                }).trigger('change').on('change', (event) => {
                    this[event.currentTarget.name] = $('#'+event.currentTarget.name).val();
                });
            });
        },
        methods: {
            initTinyMCE() {
                if ($("#mymce").length > 0) {
                    tinymce.init({
                        selector: "textarea#mymce",
                        theme: "modern",
                        height: 300,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify " +
                        "| bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    });
                }
            },
            getContent() {
                this.body = tinymce.activeEditor.getContent();
                this.sendContent();
            },
            sendContent() {
                this.body = tinymce.activeEditor.getContent();
                axios.post('/admin/api/tickets/create', this.$data)
                    .then(() => {
                        this.priority = 0;
                        this.subject = '';
                        this.body = '';

                        tinymce.activeEditor.setContent('');

                        flash(['Message has been sent']);
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
</script>