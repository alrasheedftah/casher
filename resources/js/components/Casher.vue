<template>
    <div class="container">
        <div class="container px-lg-5">
           <div class="row">
                    <div class="col-md-8  bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-auto" v-for="(item,key) in items.data" :key="key">
                        <div class="col" >
                        <div class="card text-right" style="width: 15rem; alignItems: center;padding :10px">
                            <div style="align-items: center">
                            <avatar image="http://127.0.0.1:8000/image/logo.jpg" ></avatar><!--img src="" class="card-img-top" alt="..."-->
                            </div>
                            <div class="card-body">
                                 <h5 class="card-title">{{item.name}}</h5>
                                  <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                            </div>
 
                            <!-- <div class="row">
                                <div class="col-auto">
                                    <div class="p-3 mb-2  text-danger">{{item.price}}</div>
                                </div> 
                                <div class="col-auto">
                                    <p style="align-items : right;">   $ 300 </p>
                                </div>                                 
                                <div class="col">
                                    حلويات 
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-auth">
                                    <integer-plusminus v-model="quantity[item.id]" :min="ipm_min"></integer-plusminus>
                                </div>  
                                <div class="col-auto"></div>                              
                                <div class="col-auto">
                                    <div class="p-3 mb-2  text-danger" style="font-size: 15px;">{{item.price}}ج</div>
                                </div> 
                                
                            </div>  
                                                                             
                            <!-- <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="quantity">
                                         <integer-plusminus></integer-plusminus>
                                      </div>
                                 </li>
                                <li class="list-group-item">السعر  $300</li>
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-outline-primary">اضافة</button>
                                </li>
                             </ul> -->
                             <div class="card-footer">
                                    <button type="button" class="btn btn-outline-primary btn-sm btn-block" @click="addToOrder(item,key)">اضافة للطلب </button>

                                <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                             </div>
                        </div>
                    </div>

                        </div>
                    </div>  <!-- /Col -->

                    </div>  <!-- /row -->


                    <!-- print Choising Order Palance  -->
                    <div class="col-md-4 border bg-light" id="ana">
                        <!-- <div class="container"> -->
                            <p></p>
<h3 v-if="showOrder"> <span class="float-left"> {{finalPrice}} </span> <span class="float-right"> الاجمالي </span></h3>
<h3 v-if="!showOrder"> <span class="float-md-none"> لم ينم اخيار مننج </span></h3>

<table class="table table-striped" v-show="showOrder">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">اسم المنتج</th>
      <th scope="col">الكمية</th>
      <th scope="col">السعر</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(order,key) in orders " :key="key">
      <th scope="row"><i class="fas fa-trash red" style="cursor: pointer;" @click="removeItems(order[0])"> </i></th>
      <td>{{order[0].item_name}}</td>
      <td>{{order[0].quanity}}</td>
      <td>{{order[0].price}}</td>
    </tr>
    <tr> </tr><tr></tr>
    <tr v-show="orders.length > 0" class="table-light">
      <td colspan="4">
        <button type="button" class="btn btn-outline-primary btn-lg btn-block" @click="saveOrder()">طباعة  </button>
      </td>
    </tr>
    <!-- <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr> -->
  </tbody>
</table>
                            <!-- <div class="row  row-cols-1 row-cols-sm-2 row-cols-md-4 bg-dark">
            
                            <div class="col-md-auto align-self-end">اسم المنتج</div>
                            <div class="col">الكمية</div>
                            <div class="col">السعر </div>
                           
                        </div> -->
                        
                    <!-- </div> -->
                        
                    </div>
            </div>
        </div>
    </div>
</template>

<script>

  import Avatar from 'vue-avatar-component'
  import { IntegerPlusminus } from 'vue-integer-plusminus'
    export default {
        components: { Avatar, IntegerPlusminus},

            data(){
            return{
               quantity:[], 
               items:[],
               total_price:0,
               orders:[],
               ipm_min:1,
               showOrder:false
            }
        },

        methods :{
            loadItems(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/items')
                .then(({data})=>{
                    this.items=data
                })}
            },

            addToOrder(item,key){
                this.showOrder=true
                this.orders.push([{
                    item_id:item.id,
                    item_name:item.name,
                    quanity:this.quantity[item.id],
                    price:item.price*this.quantity[item.id]
                }])
            },

            saveOrder(){
                let itemDetails = [];
                this.orders.forEach(order => {
                    itemDetails.push({
                        item_id:order[0].item_id,
                        quantity:order[0].quanity
                    })
                })
                let orderData ={
                    orderItems : itemDetails,
                    totalPrice : this.finalPrice
                }

                axios.post('/api/orders',orderData).then(()=>{
                console.log(orderData)
                })
                .catch(()=>{
                    
                })

                    this.$htmlToPaper('ana');

            },
        removeItems(item) {
          this.orders=  this.orders.filter(order => order[0].item_id != item.item_id)
          if(this.orders.length == 0)
          this.showOrder=false
    },

            print() {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    }
        },
        created() {
            this.loadItems()
        },

        computed:{
            finalPrice(){
                let total=0
                this.orders.forEach(order =>{
                    console.log(order[0].price)
                    total = total + order[0].price
                })

                return total
            }
        },

        mounted() {

            console.log('Component mounted.')
        }
    }



</script>

<style>
.pl-lg-5, .px-lg-5 {
    padding-left: 0rem !important;
}
.pr-lg-5, .px-lg-5 {
    padding-right: 0rem !important;
}
</style>





