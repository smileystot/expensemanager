<template>
    <v-list-item class="ma-4">
        <v-list-item-content>
            <v-list-item-title>{{toolbar.title}}</v-list-item-title>
        </v-list-item-content>
        <v-spacer></v-spacer>
        <v-breadcrumbs :items="toolbar.breadcrumbs" :to="toolbar.breadcrumbs.to">
            <template v-slot:divider>
            <v-icon>mdi-chevron-right</v-icon>
            </template>
        </v-breadcrumbs>
    </v-list-item>
</template>
<script>
export default {
    props:{
        toolbar:{
            type: Object
        }
    }
}
</script>