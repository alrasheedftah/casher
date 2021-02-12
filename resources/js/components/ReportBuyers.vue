<template>
          <div class="container">
        <!-- <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول المشتريات </h3>
              </div><main> -->
        <data-table v-bind="bindings" />
<!-- </main> -->
              <!-- </div> -->
            <!-- </div>
          </div>
        </div> -->
          </div>

</template>

<script>

import '@andresouzaabreu/vue-data-table/dist/DataTable.css'

export default {
    data(){
        return{
            
        }
    },

    computed: {
        bindings() {
            return {
                columns: [/*the columns*/
                {
            key: "name",
            title: "Nome",
            
          },
          {
            key: "email",
            title: "Endereço de email",
          },
          {
            key: "phone",
            title: "Telefone",
            // sortable: false,
          },
          {
            key: "country",
            title: "País",
          },
                ],
                data: [/*the data*/
            
                ]
                /* other props...*/
            }
        }
    },
}

</script>
<style >
    .column{display:none;}
</style>