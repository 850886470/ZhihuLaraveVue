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
        props:['question'],
        mounted() {
            axios.post('/api/question/follower',{'question':this.question})
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
                return this.followed ? '已关注' : '关注该问题'
            }
        },
        methods: {
            follow() {
                axios.post('/api/question/follow',{'question':this.question})
                    .then(response=>{
                        this.followed = response.data.followed
                })
            }
        }
    }
</script>
