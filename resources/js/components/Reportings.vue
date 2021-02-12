<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">التقارير  </h3>
                <div class="card-tools">
                <div class="row">
                  <div class="col-sm">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                  </div>
                  <div class="col-sm-auto">
                 
                    <!-- DropDown List To Specific Print Choise -->
<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    طباعة او تصدير
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="#" @click.prevent="exil">اكسيل</a>
    <a class="dropdown-item" href="#">PDF</a>
    <a class="dropdown-item" href="#">CSV</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" @click="printReport">طباعة</a>
  </div>
</div>
                    <!-- End DropDown -->
                 
                  </div> 
                </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="Report" class="table table-hover">
                  <thead>
                    <tr>
                      <th>رقم الطلب</th>
                       <th>الاجمالي</th>
                       <th>المستخدم</th>
                        <th>تاريخ الطلب</th>
                      <th>التحكم </th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="order in orders.data " :key="order.id">
                  <td>{{order.id}}</td>
                  <td>{{order.total}}</td>
                  <td>{{order.user.name}}</td>

                      <td>{{order.date_price | myDate}}</td>
                      <td>
                  <a href="#" > <i class="fas fa-eye" @click="getOrderDetails(order.id)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteItems(order.id)"> <i class="fas fa-trash red"> </i>
                  </a>

                  </td>
                  </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="orders"
                     @pagination-change-page="getResults" ></pagination>
                </div>

            </div>
            <!-- /.card -->
          </div>
        </div>

<div v-if="!$gate.isAdminOrAuther()">
    <not-found> </not-found>
</div>


<!-- Modal -->
<div class="modal fade" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  id="exampleModalLabel">  تفاصيل الطلب  <slot>{{orderDetailsID}} </slot></h5>
          <!-- <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات عنصر</h5> -->


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

   <form @submit.prevent="editeMode ? updatePurches() :createPurches()">
    <div class="modal-body">
        <div class="container-fluid">

                <table id="Report" class="table table-hover">
                  <thead>
                    <tr>
                      <th>اسم المنتج</th>
                       <th>الكمية</th>
                       <th>السعر</th>
                        <!-- <th>تاريخ الطلب</th>
                      <th>التحكم </th> -->
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="order in orderDetails " :key="order.id">
                    <td> {{order.name}} </td>
                    <td> {{order.pivot.quantity}} </td>
                    <td> {{(order.price * order.pivot.quantity)}} </td>

                  </tr>
                  </tbody>
                </table>

      </div>  <!-- End ModalBody  -->
      </div>  <!-- End container-fluid  -->
  

<!--       
        <form @submit.prevent="editeMode ? updatePurches() :createPurches()">
      <div class="modal-body">
        <div class="form-group">
        <input v-model="form.name" type="text" name="name"  placeholder="اسم العنصر  "
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>
        </div>


          <div class="form-group">
              <textarea v-model="form.description" name="description"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('description')}" ></textarea>
              <has-error :form="form" field="description"></has-error>
          </div>

        <div class="form-group">
        <input v-model="form.quantity" type="text" name="quantity"  placeholder="اسم العنصر  "
               class="form-control" :class="{'is-invalid':form.errors.has('quantity')}" >
            <has-error :form="form" field="quantity"></has-error>
        </div>

        <div class="form-group">
        <input v-model="form.price" type="text" name="price"  placeholder="اسم العنصر  "
               class="form-control" :class="{'is-invalid':form.errors.has('price')}" >
            <has-error :form="form" field="price"></has-error>
        </div>

        <div class="form-group">
              <select v-model="form.packaging_type" name="packaging_type"  placeholder="" id="packaging_type"
                      class="form-control" :class="{'is-invalid':form.errors.has('packaging_type')}" >
                  <option value="">اختيار نوع الحزمة </option>
                  <option value="pice">خبة  </option>
                  <option value="kr">كرتونة   </option>
                  <option value="kg">الكيلو    </option>

              </select>
              <has-error :form="form" field="packaging_type"></has-error>

          </div>


        <div class="form-group">
              <select v-model="category_id" @change="getSubCategories" name="category_id"  placeholder="" id="category_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('category_id')}" >
                  <option value="">اختيار الصنف </option>
                  <option v-for="option in categories" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" field="category_id"></has-error>

          </div>

        <div class="form-group">
              <select v-model="form.subcategory_id" name="subcategory_id"  placeholder="" id="subcategory_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('subcategory_id')}" >
                  <option value="">  اختيار الصنف الفرعي </option>
                  <option v-for="option in subCategories" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" field="subcategory_id"></has-error>

          </div>



      </div> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">اعلاق</button>
        <!-- <button v-show="editeMode" type="submit" class="btn btn-primary">تعديل </button>
          <button v-show="!editeMode" type="submit" class="btn btn-primary">حقظ</button> -->
      </div>
        <!-- </form>  -->
 </form>  <!-- End Form  -->

    </div>
  </div>
</div>

<!-- end Modal -->

    </div>
</template>

<script>
    export default {


        data(){
            return{
                editeMode:false,
                orders:{},
                orderDetails:{},
                resources:{},
                subCategories:{},
                orderDetailsID:0,
                form :new Form({
                    id:'',
                    total_price:0,
                    inputs: [{
                    quantity:[],
                    price_puyer:[],
                    component_id:[],
                    // purches_id:''
                    }],
                    date_price:'2020-10-10',
                    image:'ana.png',
                })
            }
        },

        methods:{

            updateModal(ordersData){
                this.getResources()
                this.editeMode=true
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(ordersData)
            },

            newModal(){
                this.getResources()
                this.editeMode=false
                this.form.reset()
                $('#addNewUserModal').modal('show')


            },

            loadReports(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/reports')
                .then(({data})=>{
                    this.orders=data
                })}
            },

            updatePurches(id){
                this.$Progress.start()
              this.form.put('api/reports/'+this.form.id)
                .then(()=>{
                    $('#addNewUserModal').modal('hide')
                    Swal.fire('Updated!','Updated User Successfully ','success')
                    Fire.$emit('AfterCreated')
                    this.$Progress.finish()
                })
                .catch(()=>{
                    Swal.fire('Failed','There was Somthing Wrong ','warning')
                    this.$Progress.fail()
                })
            },

            deleteItems(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // send ajax requestto delete
                        this.form.delete('api/reports/'+id).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )

                            Fire.$emit('AfterCreated')

                        })
                    }
                })
                .catch(()=>{
                    Swal.fire('Failed','There was Somthing Wrong ','warning')
                })

            },

            getResults(page=1){
              axios.get('api/reports?page='+page)
              .then(response=>{
                  this.orders=response.data
              })
            },
          createPurches(){
              this.$Progress.start();
              this.form.post('api/reports')
              .then(()=>{

                  $('#addNewUserModal').modal('hide')

                  Toast.fire({
                      icon: 'success',
                      title: 'Created User Successfully '
                  })

                  this.$Progress.finish();

                  Fire.$emit('AfterCreated');
              })
              .catch(()=>{

              })

          },
          getOrderDetails(id){
                          if(this.$gate.isAdminOrAuther()){
                  axios.get('api/orders/'+id+'/items')
                  .then(({data})=> {
                      this.orderDetails=data.data
                      }  )
              }

            this.orderDetailsID=id
            this.editeMode=true
            $('#addNewUserModal').modal('show')
          },
        getResources(event){
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/components/')
                  .then(({data})=> {
                      this.resources=data.data
                      }  )
              }
          },

          // Add Row Fields For Input 
          add () {
       this.form.inputs.push({
                    quantity:'',
                    price_puyer:0,
                    component_id:'',
                    purches_id:''
      })
      // console.log(this.form)
    },
    remove (index) {
      // removeData=this.form.inputs[index]
      var dataRemoved =this.form.inputs.splice(index, 1)
      // console.log(dataRemoved[0].price_puyer)
    },
            exil(){
 import('./../Exportxlsx').then(excel => {
  //  const orders=this.orders;
  excel.export_json_to_excel({
    header: ['Id', 'Title', 'Author', 'Readings', 'Date'], //Header Required
    data:[[1,'ana','ana','ana','ana']],//Specific data Required
    // filename: 'excel-list', //Optional
    autoWidth: true, //Optional
    bookType: 'xlsx' //Optional
  })
})

        },

          formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },


    printReport() {
     this.$htmlToPaper('Report');
    }
          //
        },

        created() {
            //this.$Progress.start();
            this.loadReports()

            Fire.$on('AfterCreated',()=>{
                this.loadReports()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/reports?q='+query)
                .then((data)=>{
                    this.orders=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadSubCategory(),3000)
            //this.$Progress.finish();
        },
        computed: {
    total(){
       var sum= this.form.inputs.reduce( (total, item) =>

        parseInt(item.price_puyer) + parseInt(total)  ,0
        
        );
        this.form.total_price=sum
        return sum
        },

  },
        //printReport
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>

<style scoped>
/* @import url('/css/Print.css'); */
</style>
<style scoped>

hr.style1{
	border-top: 1px solid #8c8b8b;
}

</style>