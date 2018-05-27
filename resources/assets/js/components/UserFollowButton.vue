<template>
    <button
            v-text="text"
            @click="follow"
            class="btn btn-default"
            :class="{'btn-success':followed}"
    ></button>
</template>

<script>
    export default {
        props:['user'],
        mounted() {
            axios.get('/api/user/followers/'+this.user)
                .then(response=>{
                    this.followed = response.data.followed
                })
        },
        data(){
            return {
                followed:false,

            }
        },
        computed: {
            text(){
                return this.followed ? '已关注' : '关注Ta'
            }
        },
        methods: {
            follow() {
                axios.post('/api/user/follow',{'user':this.user})
                    .then(response=>{
                        this.followed = response.data.followed
                    })
            }
        }
    }
</script>
