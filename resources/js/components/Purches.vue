<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول المشتريات </h3>

                <div class="card-tools">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>الرقم</th>
                       <th>الاجمالي</th>
                       <th>الفاتورة</th>
                        <th>تاريخ الفاتورة</th>
                      <th>التحكم </th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="purche in purches.data " :key="purche.id">
                  <td>{{purche.id}}</td>
                  <td>{{purche.total_price}}</td>
                  <td>{{purche.image}}</td>

                      <td>{{purche.date_price | myDate}}</td>
                      <td>
                  <a href="#" > <i class="fas fa-edit" @click="updateModal(purche)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteItems(purche.id)"> <i class="fas fa-trash red"> </i>
                  </a>

                  </td>
                  </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="purches"
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
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة عنصر</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات عنصر</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

   <form @submit.prevent="editeMode ? updatePurches() :createPurches()">
    <div class="modal-body">
        <div class="container-fluid">
        <div class="row" v-for="(input,k) in form.inputs" :key="k">
            <div class="col-auto">
               <button @click.prevent="add(k)" v-show="k == form.inputs.length-1" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="اضافة مكون اخر">  
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clipboard-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                    <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zM8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                </svg>
               </button> 
            <!-- col col-lg-2 -->

<button @click.prevent="remove(k)" v-show="k || ( !k && form.inputs.length > 1)" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="اضافة مكون اخر">  
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg>
</button>
            </div>


             <div class="col-md-6">
        <div class="form-group">
              <select v-model="form.inputs[k].component_id" @change="getResources" :name="`component_id`"  placeholder="" id="component_id"
                      class="form-control" :class="{'is-invalid':form.errors.has(`inputs.${k}.component_id`)}" >
                  <option value="">اختيار المكون </option>
                  <option v-for="option in resources" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" :field="`inputs.${k}.component_id`"></has-error>

          </div>

             </div>
             <div class="col">
             <div class="form-group">
                      <input v-model="form.inputs[k].quantity" type="number" name="quantity[]"  :placeholder="'الكمية'  "
                 class="form-control" :class="{'is-invalid':form.errors.has(`inputs.${k}.quantity`)}" >
                 <has-error :form="form" :field="`inputs.${k}.quantity`"></has-error>
             </div >
               
             </div>

        <div class="col">
             <div class="form-group">
                      <input v-model="form.inputs[k].price_puyer" type="number" name="price_puyer[]"  placeholder="سعر الشراء"
                 class="form-control" :class="{'is-invalid':form.errors.has(`inputs.${k}.price_puyer`)}" >
                 <has-error :form="form" :field="`inputs.${k}.price_puyer`"></has-error>
             </div >
               
             </div>



      </div>  <!-- End Row  -->


<br>
<br> <!--  Seprator  -->
<hr class="style1">
<div class="row align-items-center">
    <div class="col">
   <div class="custom-file form-group">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">الرجاء ارفاق صورة الفاتورة</label>
    </div> 
    </div>
    <div class="col-3">
      
  <div class="form-group" align="right">
    <label for="formGroupExampleInput" >الاجمالي</label>
    <input v-model="form.total_price"  type="text" class="form-control" id="formGroupExampleInput" :placeholder="total" readonly>
  </div>
    </div>
  </div>

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
        <button v-show="editeMode" type="submit" class="btn btn-primary">تعديل </button>
          <button v-show="!editeMode" type="submit" class="btn btn-primary">حقظ</button>
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
                purches:{},
                resources:{},
                subCategories:{},
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

            updateModal(purchesData){
                this.getResources()
                this.editeMode=true
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(purchesData)
            },

            newModal(){
                this.getResources()
                this.editeMode=false
                this.form.reset()
                $('#addNewUserModal').modal('show')


            },

            loadPurches(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/purches')
                .then(({data})=>{
                    this.purches=data
                })}
            },

            updatePurches(id){
                this.$Progress.start()
              this.form.put('api/purches/'+this.form.id)
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
                        this.form.delete('api/purches/'+id).then(()=>{
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
              axios.get('api/purches?page='+page)
              .then(response=>{
                  this.purches=response.data
              })
            },
          createPurches(){
              this.$Progress.start();
              this.form.post('api/purches')
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
          getCategories(){
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/categories')
                  .then(({data})=> {
                      this.categories=data.data
                      }  )
              }
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
          //
        },

        created() {
            //this.$Progress.start();
            this.loadPurches()

            Fire.$on('AfterCreated',()=>{
                this.loadPurches()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/purches?q='+query)
                .then((data)=>{
                    this.purches=data.data
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
        }
  },
        //
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>


<style scoped>

hr.style1{
	border-top: 1px solid #8c8b8b;
}

</style>