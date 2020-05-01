<template>
    <v-app id="inspire" v-cloak>
        <v-navigation-drawer
            v-model="drawer"
            app
            color="#134f5c"
            dark
        >
            <v-list dense nav class="py-5">
                <v-list-item class="px-2">
                    <v-menu offset-y transition="slide-y-transition" content-class="profile-menu" :nudge-width="200">
                        <template v-slot:activator="{ on: menu }">
                            <v-tooltip bottom>
                            <template v-slot:activator="{ on: tooltip }">
                                <v-btn icon v-on="{ ...tooltip, ...menu }" class="app-apps">
                                    <v-avatar size="32px">
                                        <v-img src="https://randomuser.me/api/portraits/women/85.jpg"></v-img>
                                    </v-avatar>
                                </v-btn>
                            </template>
                            <span>Profile Settings</span>
                            </v-tooltip>
                        </template>
                        <v-list>
                            <v-list-item-group>
                                <v-list-item @click="passwordDialog = true" style="height:24px !important">
                                    <v-list-item-icon>
                                        <v-icon>mdi-account-key</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Change Password</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-item-group>
                        </v-list>
                    </v-menu>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">{{auth_name}} ({{role_name}})</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <!--  -->
            <!--  -->
            <v-list
                dense
                nav
            >
                <v-list-item link to="/">
                    <v-list-item-content>
                        <v-list-item-title>Dashbord</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-if="role_id == 1">
                    <v-list-item-content>
                        <v-list-item-title>User Management</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                    <v-list-item 
                        link 
                        to="/roles"
                        class="pl-5"
                        v-if="role_id == 1"
                    >
                    <v-list-item-content>
                        <v-list-item-title>Roles</v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                    <v-list-item 
                        link 
                        to="/users"
                        class="pl-5"
                        v-if="role_id == 1"
                    >
                    <v-list-item-content>
                        <v-list-item-title>Users</v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>Expense Management</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                    <v-list-item 
                        link 
                        to="/categories"
                        class="pl-5"
                        v-if="role_id == 1"
                    >
                    <v-list-item-content>
                        <v-list-item-title>Expenses Categories</v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                    <v-list-item 
                        link 
                        to="/expenses"
                        class="pl-5"
                    >
                    <v-list-item-content>
                        <v-list-item-title>Expenses</v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <!-- logOut Form -->
            <v-form id="logOut" method="post" action="/logout">
                <input type="hidden" name="_token" :value="csrf">
                <v-btn type="submit" style="visibility: hidden;" text color="blue-grey darken-3">Submit</v-btn>
            </v-form>
            <!-- End logOut Form -->
        <v-app-bar
            app
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-spacer></v-spacer>
            <v-toolbar-title>Welcome to Expense Manager</v-toolbar-title>
            <v-btn text @click="logOut">Logout</v-btn>
        </v-app-bar>
        <router-view></router-view>
        <v-dialog v-model="passwordDialog" persistent max-width="600" @keydown.esc="passwordDialog = false">
            <v-form id="changePassword" ref="changePassword" @submit.prevent="changePassword" enctype="multipart/form-data">
                <v-card>
                    <v-card-title>
                        <span class="headline">Change Password</span>
                    </v-card-title>
                    <v-card-text class="pa-0">
                        <v-container>
                            <v-row>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    New password
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        v-model="tempPassword"
                                        type="password"
                                        :rules="rules.required"
                                        name="password"
                                        outlined
                                        dense
                                        autofocus
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Verify password
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        v-model="tempVerifyPassword"
                                        type="password"
                                        :rules="[rules.required,passwordConfirmationRule]" 
                                        name="new"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <input type="hidden" name="id" :value="auth_id">
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                        <v-btn @click="passwordDialog = false">Cancel</v-btn>
                        <v-btn type="submit">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
    </v-app>
</template>

<script>
    import { mapState , mapGetters , mapActions } from 'vuex'
    export default {
        data: () => ({
            drawer: null,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            auth_id: auth_id,
            auth_name:auth_name,
            role_id: role_id,
            role_name: role_name,
            passwordDialog: false,
            tempPassword: '',
            tempVerifyPassword: ''
        }),
        methods: {
            changePassword(){
                var self =  this
                if(this.$refs.changePassword.validate()){
                    var myform = document.getElementById('changePassword');
                    var formdata = new FormData(myform);
                    self.$store.state.loading = true
                    self.passwordDialog = false;
                    axios({
                        method: 'post',
                        url: '/change/password',
                        data: formdata
                    })
                    .then(function (response) {
                        self.$store.state.loading = false
                    })
                    .catch(function (response) {
                        console.log(response);
                    }); 
                }
                return false;
            },
            logOut(){
                document.getElementById("logOut").submit(); 
            },
        },
        computed: {
            passwordConfirmationRule() {
                return () => (this.tempPassword === this.tempVerifyPassword) || 'Password must match'
            },
            ...mapState(['rules','loading'])
        },
    }
</script>