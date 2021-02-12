<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول الاصناف الفرعية </h3>

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
                      <th>اسم  العنصر  </th>
                      <th>الوصف </th>
                      <th>نوع الحزمة</th>
                      <th>الكمية  </th>
                      <th>السعر  </th>
                      <th>يتبع لصنف </th>

                        <th>الانشاء</th>
                      <th>التحكم </th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="item in items.data " :key="item.id">
                  <td>{{item.id}}</td>
                  <td>{{item.name}}</td>
                  <td>{{item.description}}</td>
                  <td>{{item.packaging_type}}</td>
                  <td>{{item.quantity}}</td>
                  <td>{{item.price}}</td>
                  <td>{{item.subcategory.name}}</td>

                  <td><span class="tag tag-success">{{item.icon}}</span></td>
                      <td>{{item.created | myDate}}</td>
                      <td>
                  <a href="#" > <i class="fas fa-edit" @click="updateModal(item)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteItems(item.id)"> <i class="fas fa-trash red"> </i>
                  </a>

                  </td>
                  </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="items"
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
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة عنصر</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات عنصر</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="editeMode ? updateItems() :createItems()">
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



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">اعلاق</button>
        <button v-show="editeMode" type="submit" class="btn btn-primary">تعديل </button>
          <button v-show="!editeMode" type="submit" class="btn btn-primary">حقظ</button>
      </div>
        </form>

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
                items:{},
                categories:{},
                subCategories:{},
                category_id:'',
                form :new Form({
                    id:'',
                    name:'',
                    description:'',
                    packaging_type:'',
                    quantity:0,
                    price:0,
                    photo:'',
                    subcategory_id:''
                })
            }
        },

        methods:{

            updateModal(itemDate){
                this.getCategories()
                this.editeMode=true
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(itemDate)
            },

            newModal(){
                this.getCategories()
                this.editeMode=false
                this.form.reset()
                $('#addNewUserModal').modal('show')

            },

            loadItems(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/items')
                .then(({data})=>{
                    this.items=data
                })}
            },

            updateItems(id){
                this.$Progress.start()
              this.form.put('api/items/'+this.form.id)
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
                        this.form.delete('api/items/'+id).then(()=>{
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
              axios.get('api/items?page='+page)
              .then(response=>{
                  this.items=response.data
              })
            },
          createItems(){
              this.$Progress.start();
              this.form.post('api/items')
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
        getSubCategories(event){
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/categories/'+this.category_id+'/subcategories')
                  .then(({data})=> {
                      this.subCategories=data.data
                      }  )
              }
          },
          //
        },

        created() {
            //this.$Progress.start();
            this.loadItems()

            Fire.$on('AfterCreated',()=>{
                this.loadItems()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/items?q='+query)
                .then((data)=>{
                    this.items=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadSubCategory(),3000)
            //this.$Progress.finish();
        },
        //
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>
