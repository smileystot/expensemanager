<template>
    <v-content>
        <tool-bar :toolbar="toolbar"></tool-bar>
        <v-container class="px-10">
            <v-simple-table fixed-header>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>Expenses Category</th>
                            <th>Amount</th>
                            <th>Entry Date</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(expense,index) in expenses" :key="index" @click="Edit(expense)">
                            <td>{{expense.category_name}}</td>
                            <td><v-icon>mdi-currency-usd</v-icon>{{expense.amount}}</td>
                            <td>{{expense.entry_date}}</td>
                            <td>{{expense.created_at}}</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
            <v-row>
                <v-col cols="10" sm="10" md="10">
                </v-col>
                <v-col cols="2" sm="2" md="2">
                    <v-btn @click="insertDialog = true">Add Expense</v-btn>
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
                            <span class="headline">Add Expense</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Expense Category
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-select
                                        :items="categories"
                                        :rules="rules.required"
                                        item-text="name"
                                        item-value="id"
                                        name="category_id"
                                        dense
                                        outlined
                                        clearable
                                    ></v-select>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Amount
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        :rules="rules.amount"
                                        name="amount"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Entry Date
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-menu
                                        v-model="pickerDialog"
                                        :close-on-content-click="false"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :value="tempDate"
                                                v-on="on"
                                                @click:clear="tempDate = null"
                                                :rules="rules.required"
                                                placeholder="    /  /  " 
                                                name="entry_date"
                                                clearable
                                                dense
                                                outlined
                                                readonly
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="tempDate"
                                            @change="pickerDialog = false"
                                        ></v-date-picker>
                                    </v-menu>
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
                            <span class="headline">Update Expenses</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Expense Category
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-select
                                        :value="editData.category_id"
                                        :items="categories"
                                        :rules="rules.required"
                                        item-text="name"
                                        item-value="id"
                                        name="category_id"
                                        dense
                                        outlined
                                        clearable
                                    ></v-select>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Amount
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-text-field
                                        :value="editData.amount"
                                        :rules="rules.amount"
                                        name="amount"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4" sm="4" md="4" class="cols">
                                    Entry Date
                                </v-col>
                                <v-col cols="7" sm="7" md="7" class="cols">
                                    <v-menu
                                        v-model="pickerDialog"
                                        :close-on-content-click="false"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :value="tempDate"
                                                v-on="on"
                                                @click:clear="tempDate = null"
                                                :rules="rules.required"
                                                placeholder="    /  /  " 
                                                name="entry_date"
                                                clearable
                                                dense
                                                outlined
                                                readonly
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="tempDate"
                                            @change="pickerDialog = false"
                                        ></v-date-picker>
                                    </v-menu>
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
    </v-content>
</template>
<script>
    import Toolbar from '../components/Toolbar'
    import { mapState , mapGetters , mapActions } from 'vuex'
    export default {
        name: 'Categories',
        components:{
            'tool-bar': Toolbar
        },
        data() {
            return {
                toolbar:{
                    title: "Expense",
                    breadcrumbs:[
                        {
                            text: 'Expense Management',
                            disabled: false,
                        },
                        {
                            text: 'Expense',
                            disabled: true,
                        }
                    ]
                },
                insertDialog: false,
                editDialog: false,
                editData: [],
                pickerDialog: false,
                tempDate: ''
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
                        url: 'expenses/insert',
                        data: formdata
                    })
                    .then(function (response) {
                        self.$refs.Insert.reset()
                        self.insertDialog = false
                        self.$store.state.loading = false
                        self.$store.dispatch("getExpenses")
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
                }
            },
            Edit(data){
                this.editData = data;
                this.editDialog = true
                this.tempDate = data.entry_date
            },
            Update(){
                var self =  this
                if(this.$refs.Update.validate()){
                    var myform = document.getElementById('Update');
                    var formdata = new FormData(myform);
                    self.$store.state.loading = true
                    axios({
                        method: 'post',
                        url: 'expenses/update',
                        data: formdata
                    })
                    .then(function (response) {
                        self.editDialog = false
                        self.$store.state.loading = false
                        self.$store.dispatch("getExpenses")
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
                    url: 'expenses/delete',
                    data: formdata
                })
                .then(function (response) {
                    self.editDialog = false
                    self.$store.state.loading = false
                    self.$store.dispatch("getExpenses")
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
                'categories',
                'expenses'
            ])
        },
        watch: {
            editDialog: function (val) {
                if(!val){
                    this.tempDate = '';
                }
            }
        },
        created() {
            this.$store.dispatch("getExpenses")
            this.$store.dispatch("getCategories")
        },
    }
</script>