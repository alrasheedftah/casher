<template>
<div>
<!-- <div class="toolbar">
        <a href="" class="btn btn-primary"><i class="fas fa-plus-circle">AddNew</i></a>
        <a href="" class="btn btn-danger"><i class="fas fa-trash-alt">Remove</i></a> -->
      <!-- <bootstrap-table ></bootstrap-table> -->

<!-- </div> -->
    <bootstrap-table ref="table" :data='data' :options='myOption' :columns='myColumn' locale='ar'></bootstrap-table>
</div>
    <!-- <div > -->

     <!-- <div class="row">
      <div class="col-12 col-md-9">
        Below are client-side buttons demo, go here to see
        <a
          href="https://laratt.niiknow.org/home/contacts"
          target="_blank"
        >
          server-side buttons demo
        </a>
      </div>
      <div class="col-12 col-md-3">
        <form
          class="form-inline d-flex mx-1 justify-content-end"
          @submit.stop.prevent="doSearch"
        >
          <div class="input-group">
            <input
              v-model="quickSearch"
              type="search"
              placeholder="Quick search"
              class="form-control"
            >
            <div class="input-group-append">
              <button
                type="submit"
                class="btn btn-outline-secondary"
              >
                <i class="mdi mdi-magnify" /> Go
              </button>
            </div>
          </div>
        </form>
      </div>
    </div-->
    <!-- Using the VdtnetTable component -->
    <!-- <vdtnet-table
      ref="table"
      :fields="fields"
      :opts="options"
      :select-checkbox="1"
      :details="details"
      @edit="doAlertEdit"
      @delete="doAlertDelete"
      @reloaded="doAfterReload"
      @table-creating="doCreating"
      @table-created="doCreated"
    >
      <template slot="HEAD__details_control">
        <b>Show Details</b>
      </template>
      <template
        slot="address2"
        slot-scope="ctx"
      >
        <span>{{ ctx.data.city }}, {{ ctx.comp.formatCode(ctx.data.zipcode) }}</span>
      </template>
      <template
        slot="_details"
        slot-scope="ctx"
      >
        <strong>I'm a child for {{ ctx.data.id }} yall</strong>
      </template>
    </vdtnet-table>
  </div> --> 
</template>


   <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table-vue.min.js"></script-->
// bootstrap-table-ar-SA.js
<script>
// require('jquery');

    // require('@fortawesome/fontawesome-free/js/all')
    // import $ from 'jquery'
    // import {BootstrapTable} from 'bootstrap-table/dist/bootstrap-table-vue'
 
// below you should only import what you need
// Example: import buttons and plugins
// import 'datatables.net-buttons/js/dataTables.buttons.js'
// import 'datatables.net-buttons/js/buttons.html5.js'
// import 'datatables.net-buttons/js/buttons.print.js'
 
// import the rest for your specific theme
// import 'datatables.net-buttons-bs4'
// import 'datatables.net-select-bs4'
 
// import 'datatables.net-select-bs4/css/select.bootstrap4.min.css'
// import 'datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'

// import VdtnetTable from 'vue-datatables-net'
// import 'datatables.net-bs4'


// import {BootstrapTable} from 'bootstrap-table/dist/bootstrap-table-vue'


    export default {
        components:{
            //  VdtnetTable ,
            //  'BootstrapTable': require('bootstrap-table/dist/bootstrap-table-vue')
        },

        data(){
            return{
                data:[
                  {id:1,name:'ana','status':true},
                  // {id:1,name:'ana','status':true},
                  // {id:1,name:'ana','status':true},
                  // {id:1,name:'ana','status':true},

                ],
                myOption:{
                    search:true,  
                    pagination:true,
                    showColumns:true,
                    showPrint:true,
                    showExport:true,
                    filterControl:true,
                    toolbar:'#toolbar',
                    // locale:'ar-SA',
                    // refreshOptions:'ar-SA'
                },
                myColumn:[
                  {field:'id', title:'الرقم',sortable:true},
                  {field:'name', title:'الاسم',sortable:true,filterControl:'input'},
                  {field:'status', title:'الحالة',sortable:true,filterControl:'select'},
                  {
                    field:'action',
                    title:'الحكم ',
                    align:'center',
                    width:'4px',
                    formatteer:function(e ,value,row){
                      `<button class="btn btn-sm btn-info mr-1 show"><i class="fas fa-eye"></i></button>
<button class="btn btn-sm btn-warning mr-1 edit"><i class="fas fa-edit"></i></button>
<button class="btn btn-sm btn-danger mr-1 destroy"><i class="fas fa-trash"></i></button>
`
                    },  
                    events:{
                        'click .show':function(e,value,row){
                            return  window.location.assign('/reports'+row.id)
                        }
                    }
                  }


                ]
            }
        },
        created(){

        },
        mounted() {
        // var t= this.$refs.table.refreshOptions({
        //     locale:'ar-SA'
        //   })
            console.log(this.$refs.table.getOptions())
            // console.log(t)
        }
    }

//     data() {
//     const vm = this
//     return   {
//       options: {
//         ajax: {
//           url: 'https://jsonplaceholder.typicode.com/users',
//           dataSrc: (json) => {
//             return json
//           }
//         },
//         buttons: ['copy', 'csv', 'print'],
// /*eslint-disable */
//         dom: "Btr<'row vdtnet-footer'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'pl>>",
// /*eslint-enable */
//         responsive: false,
//         processing: true,
//         searching: true,
//         searchDelay: 1500,
//         destroy: true,
//         ordering: true,
//         lengthChange: true,
//         serverSide: true,
//         fixedHeader: true,
//         saveState: true /*,
//         select: {
//           style: 'multi'
//         }*/
//       },
//       fields: {
//         id: { label: 'ID', sortable: true },
//         actions: {
//           isLocal: true,
//           label: 'Actions',
//           defaultContent: '<a href="javascript:void(0);" data-action="edit" class="btn btn-primary btn-sm"><i class="mdi mdi-square-edit-outline"></i> Edit</a>' +
//             '<span data-action="delete" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i> Delete</span>'
//         },
//         name: { label: 'Name', sortable: true, searchable: true, defaultOrder: 'desc' },
//         username: { label: 'Username', sortable: false, searchable: true  },
//         email: { label: 'Email' },
//         address1: {
//           label: 'Address1',
//           data: 'address',
//           template: '{{ data.street }}, {{ data.suite }}'
//         },
//         address2: {
//           label: 'Address2',
//           data: 'address'
//         },
//         phone: { label: 'Phone' },
//         website: {
//           label: 'Website',
//           render: (data) => {
//             return `https://${ data }`
//           }
//         }
//       },
//       quickSearch: '',
//       details: {}
//     }
//   },
//   methods: {
//     doLoadTable(cb) {
//       $.getJSON( 'https://jsonplaceholder.typicode.com/users', function( data ) {
//         cb(data)
//       })
//     },
//     doAlertEdit(data) {
//       window.alert(`row edit click for item ID: ${data.id}`)
//     },
//     doAlertDelete(data, row, tr, target) {
//       window.alert(`deleting item ID: ${data.id}`)
//       // row.remove() doesn't work when serverside is enabled
//       // so we fake it with dom remove
//       tr.remove()
//       const table = this.$refs.table
//       setTimeout(() => {
//         // simulate extra long running ajax
//         table.reload()
//       }, 1500)
//     },
//     doAfterReload(data, table) {
//       window.alert('data reloaded')
//     },
//     doCreating(comp, el) {
//       console.log('creating')
//     },
//     doCreated(comp) {
//       console.log('created')
//     },
//     doSearch() {
//       this.$refs.table.search(this.quickSearch)
//     },
//     doExport(type) {
//       const parms = this.$refs.table.getServerParams()
//       parms.export = type
//       window.alert('GET /api/v1/export?' + jQuery.param(parms))
//     },
//     formatCode(zipcode) {
//       return zipcode.split('-')[0]
//     }
//   }
// }
</script>

<style scoped>
</style>
