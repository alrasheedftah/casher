<template>
<!-- <div> -->
<!-- <div class="toolbar">
      <a href="" class="btn btn-primary"><i class="fas fa-plus-circle">AddNew</i></a>
      <a href="" class="btn btn-danger"><i class="fas fa-trash-alt">Remove</i></a>
</div> -->
      <!-- <bootstrap-table :data='data' :options='myOption' :columns='myColumn' ></bootstrap-table> -->
          <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول المشتريات </h3>
              </div>

<datatable :columns="columns" :sortKey="sortKey" sortOrder="sortOrder"></datatable>

            </div>
          </div>
        </div>
          </div>
<!-- </div> -->
</template>

<script>
    import Datatable from './Datatable'
    export default {
        components:{
            Datatable   
        },

        data(){
            let sortOrder={}

            let columns=[
                {width:'55%',label:'الرقم',name:'id'},
                {width:'55%',label:'الاسم',name:'name'},
                {width:'55%',label:'الكمية',name:'quantity'},

            ]

            columns.forEach((column)=>{
                sortOrder[column.name]=-1
            })

            return{
                items:[],
                columns:columns,
                sortKey:'id',
                sortOrder:sortOrder,
                tableData:{
                    draw:0,
                    length:10,
                    search:'',
                    column:0,
                    dir:'desc'
                }
            };

            
        },

        methods:{
            getItems(){
                this.tableData.draw++
                axios.get('api/purches')
                .then(({data})=>{
                    this.purches=data.data
                })
            }
        },

        created(){
            this.getItems()
        }





    //     components:{
    //         //  VdtnetTable ,
    //         //  'BootstrapTable': require('bootstrap-table/dist/bootstrap-table-vue')
    //     },

    //     data(){
    //         return{
    //             data:[
    //               {id:1,name:'ana','status':true,action:''},
    //             ],
    //             myOption:{
    //                 search:true,  
    //                 pagination:true,
    //                 showColumns:true,
    //                 showPrint:true,
    //                 showExport:true,
    //                 filterControl:true,
    //                 toolbar:'#toolbar',
    //                 // locale:'ar-SA',
    //                 // refreshOptions:'ar-SA'
    //             },
    //             myColumn:[
    //               {field:'id', title:'الرقم',sortable:true},
    //               {field:'name', title:'الاسم',sortable:true,filterControl:'input'},
    //               {field:'status', title:'الحالة',sortable:true,filterControl:'select'},
    //             //   {
    //             //     field:'action',
    //             //     title:'التحكم',
    //             //     align:'center',
    //             //     width:'140px',
    //             //     formatter:function(e ,value,row){
    //             //       '<button class="btn btn-sm btn-info mr-1 show"><i class="fas fa-eye"></i></button><button class="btn btn-sm btn-warning mr-1 edit"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-danger mr-1 destroy"><i class="fas fa-trash"></i></button>'
    //             //     },  
    //             //     events:{
    //             //         'click .show':function(e,value,row){
    //             //             return  window.location.assign('/reports'+row.id)
    //             //         }
    //             //     }
    //             //   }


    //             ]
    //         }
    //     },
    //     created(){

    //     },
    //     mounted() {
    //     // var t= this.$refs.table.refreshOptions({
    //     //     locale:'ar-SA'
    //     //   })
    //         console.log(this.$refs.table.getOptions())
    //         // console.log(t)
    //     }
    }
</script>
<style scoped>

</style>