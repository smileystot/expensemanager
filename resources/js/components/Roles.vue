<template>
    <v-content>
        <tool-bar :toolbar="toolbar"></tool-bar>
        <v-container class="px-10">
            <v-simple-table fixed-header>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(role,index) in roles" :key="index" @click="Edit(role)">
                            <td>{{role.name}}</td>
                            <td>{{role.description}}</td>
                            <td>{{role.created_at}}</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
            <v-row>
                <v-col cols="10" sm="10" md="10">
                </v-col>
                <v-col cols="2" sm="2" md="2">
                    <v-btn @click="insertDialog = true">Add Role</v-btn>
                </v-col>
            </v-row>
        </v-container>
        <!-- Loading -->
        <v-overlay :value="loading" overlay>
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <!-- End Loading -->
        <!-- Insert Dailog -->
        <v-row justify="center">
            <v-dialog v-model="insertDialog" persistent max-width="600" @keydown.esc="insertDialog = false">
                <v-form id="Insert" ref="Insert" @submit.prevent="Insert" enctype="multipart/form-data">
                    <v-card>
                        <v-card-title>
                            <span class="headline">Add Role</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Display Name
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        :rules="rules.required"
                                        name="name"
                                        outlined
                                        dense
                                        autofocus
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Description
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        name="description"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                            <v-btn @click="insertDialog = false">Cancel</v-btn>
                            <v-btn type="submit">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
        <!-- End Insert Dialog -->
        <!-- Edit Dailog -->
        <v-row justify="center">
            <v-dialog v-model="editDialog" persistent max-width="600" @keydown.esc="editDialog = false">
                <v-form id="Update" ref="Update" @submit.prevent="Update" enctype="multipart/form-data">
                    <v-card>
                        <v-card-title>
                            <span class="headline">Update Role</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Display Name
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        :value="editData.name"
                                        :rules="rules.required"
                                        name="name"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Description
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        :value="editData.description"
                                        name="description"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <input type="hidden" name="id" :value="editData.id">
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn @click="Delete()">Delete</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn @click="editDialog = false">Cancel</v-btn>
                            <v-btn type="submit">Update</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
        <!-- End Edit Dialog -->
        <snack-bar :snackbar="snackbar"></snack-bar>
    </v-content>
</template>
<script>
    import Toolbar from '../components/Toolbar'
    import Snackbar from '../components/Snackbar'
    import { mapState , mapGetters , mapActions } from 'vuex'
    export default {
        name: 'Roles',
        components:{
            'tool-bar': Toolbar,
            'snack-bar': Snackbar,
        },
        data() {
            return {
                toolbar:{
                    title: "Roles",
                    breadcrumbs:[
                        {
                            text: 'User Management',
                            disabled: false,
                        },
                        {
                            text: 'Roles',
                            disabled: true,
                        }
                    ]
                },
                insertDialog: false,
                editDialog: false,
                editData: [],
                snackbar:{
                    show: false,
                    text: null
                }

            }
        },
        methods: {
            Insert(){
                var self =  this
                if(this.$refs.Insert.validate()){
                    var myform = document.getElementById('Insert');
                    var formdata = new FormData(myform);
                    self.$store.state.loading = true
                    axios({
                        method: 'post',
                        url: 'roles/insert',
                        data: formdata
                    })
                    .then(function (response) {
                        self.$refs.Insert.reset()
                        self.insertDialog = false
                        self.$store.state.loading = false
                        self.$store.dispatch("getRoles")
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
                }
            },
            Edit(data){
                this.editData = data;
                if(data.id !== 1){
                    this.editDialog = true
                }else{
                    this.snackbar.show = true
                    this.snackbar.text = "Administrator Role cannot be updated/deleted"
                }
                
            },
            Update(){
                var self =  this
                if(this.$refs.Update.validate()){
                    var myform = document.getElementById('Update');
                    var formdata = new FormData(myform);
                    self.$store.state.loading = true
                    axios({
                        method: 'post',
                        url: 'roles/update',
                        data: formdata
                    })
                    .then(function (response) {
                        self.editDialog = false
                        self.$store.state.loading = false
                        self.$store.dispatch("getRoles")
                    })
                    .catch(function (response) {
                        console.log(response);
                    });  
                }
            },
            Delete(){
                var self =  this
                var myform = document.getElementById('Update');
                var formdata = new FormData(myform);
                self.$store.state.loading = true
                axios({
                    method: 'post',
                    url: 'roles/delete',
                    data: formdata
                })
                .then(function (response) {
                    self.editDialog = false
                    self.$store.state.loading = false
                    self.$store.dispatch("getRoles")
                })
                .catch(function (response) {
                    console.log(response);
                });
            }
        },
        computed: {
            ...mapState([
                'rules',
                'loading',
                'roles'
            ])
        },
        created() {
            this.$store.dispatch("getRoles")
        },
    }
</script>