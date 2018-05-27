<template>
    <div>
        <button
                @click="showSendMessageForm"
                class="btn btn-default pull-right"
        >发送私信</button>

        <div class="modal fade" id="modal-send-message" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            发送私信
                        </h4>

                    </div>

                    <div class="modal-body">
                        <textarea v-model="body" name="body" class="form-control" v-if="!status"></textarea>
                        <div class="alert alert-success" v-if="status">
                            <strong>私信发送成功</strong>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button @click="store" type="button" class="btn btn-primary" data-dismiss="modal">发送私信</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props:['user'],
        data(){
            return {
                body:'',
                status:false
            }
        },
        methods: {
            store() {
                axios.post('/api/message/store',{'user':this.user,'body':this.body})
                    .then(response=>{
                        this.status = response.data.status
                        setTimeout(function(){
                            $("#modal-send-message").modal('hide')
                        },2000)

                    })
            },
            showSendMessageForm(){
                $("#modal-send-message").modal('show')
            }
        }
    }
</script>
