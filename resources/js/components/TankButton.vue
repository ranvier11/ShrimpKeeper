<template>
    <b-button class="is-pulled-right is-info" @click="emitClick()" >
                {{ name }}
        </b-button>

</template>
<script>
export default {
    props: {
        name: {
            type: String,
        },
        icon: "plus-box"
    },
    methods: {
        emitClick () {
            this.$emit('clicked')
        }
    }
}
</script>
