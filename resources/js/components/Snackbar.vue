<template>
    <div>
        <v-snackbar
            v-model="snackbar.show"
            color="#134f5c"
            :timeout=timeout
        >
        {{ snackbar.text }}
        <v-btn
            color="blue"
            text
            @click="snackbar.show = false"
        >
            Close
        </v-btn>
        </v-snackbar>
    </div>
</template>
<script>
export default {
    props:{
        snackbar:{
            type: Object
        }
    },
    data() {
        return {
            timeout: 2000
        }
    },
}
</script>