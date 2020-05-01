<template>
    <v-content>
        <tool-bar :toolbar="toolbar"></tool-bar>
        <v-container class="px-10">
            <v-row>
                <v-col offset-md="2"  md="2" sm="2">
                    Expense Categories
                    <v-list class="mt-3">
                        <v-list-item
                            v-for="(report,index) in reports"
                            :key="index"
                        >
                            <v-list-item-content>
                            <v-list-item-title v-text="report.category_name"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col md="2" sm="2">
                    Total
                    <v-list class="mt-3">
                        <v-list-item
                            v-for="(report,index) in reports"
                            :key="index"
                        >
                            <v-list-item-content>
                            <v-list-item-title v-text="report.sum"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col md="2" sm="2">
                    <apexchart type="pie" width="380" :options="chartOptions" :series="series"></apexchart>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>
<script>
    import Toolbar from '../components/Toolbar'
    import VueApexCharts from 'vue-apexcharts'
    import { mapState , mapGetters , mapActions } from 'vuex'
    export default {
        components:{
            'tool-bar': Toolbar,
            'apexchart': VueApexCharts
        },
        data() {
            return {
                toolbar:{
                    title: "My Expenses",
                    breadcrumbs:[
                        {
                            text: 'Dashboard',
                            disabled: true,
                        }
                    ]
                },
                auth_id:auth_id
            }
        },
        computed: {
            series(){
                return _.map(this.reports, 'sum');
                // return this.reports;
            },  
            chartOptions(){
                return {
                    chart: {
                        width: 400,
                        type: 'pie',
                    },
                    labels: _.map(this.reports, 'category_name'),
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                    }]
                }
            },
            ...mapState(['reports'])
        },
        created() {
            this.$store.dispatch("getReports")
        },
        mounted() {
            console.log(this.reports)
        },
    }
</script>