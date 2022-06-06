<template>
  <div>
      <app-layout title="Resort Add">
          <template #header>
              <h4 class="mb-sm-0 font-size-18">{{pageName}}</h4>
              <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item">
                          <Link :href="route('dashboard')"> Dashboard </Link>
                      </li>
                      <li class="breadcrumb-item active">{{pageName}}</li>
                  </ol>
              </div>
          </template>
          <div class="col-12">
                  <div class="card">
                      <div class="card-body">
                          <div class="row mb-2">
                              <div class="col-sm-12">
                                  <div class="text-sm-end">
                                      <Link  :href="route(urlName+'.index')" class="btn btn-info btn-rounded waves-effect waves-light mb-2 me-2"><i class="bx bx-right-arrow-alt"></i>
                                          {{ pageName }}
                                      </Link>
                                  </div>
                              </div><!-- end col-->
                          </div>
                          <form enctype="multipart/form-data" @submit.prevent="submit" action="">
                             <div class="row mt-3">
                                <div class="col-md-6">
                                   <div class="mb-3">
                                       <label for="code" class="form-label">Code</label>
                                       <input type="text" class="form-control" id="code" name="code" v-model="form.code" @keyup="codeInputer()">
                                       <span  v-if="form.errors.code" class="text-danger">{{form.errors.code}}</span>
                                   </div>
                                   <div class="mb-3">
                                       <label for="name" class="form-label">Name</label>
                                       <input type="text" class="form-control" id="name" name="name" v-model="form.name">
                                       <span  v-if="form.errors.name" class="text-danger">{{form.errors.name}}</span>
                                   </div>
                                   <div class="mb-3">
                                       <label for="image" class="form-label">Image</label>
                                       <input class="form-control" type="file" id="image" @change="loadThumbnail($event)" name="image" >
                                       <div class="preview_image_box" v-if="form.image" @click="form.image=''">
                                           <span class="text-danger border ">&times;</span>
                                           <img  :src="form.image" class="img-fluid preview_image">
                                       </div>

                                       <img  :src="thumnailReturn(item.image)" class="img-fluid preview_image">
                                       <span  v-if="form.errors.image" class="text-danger">{{form.errors.image}}</span>
                                   </div>
                                   <div class="md-3">
                                       <div class="mt-4">
                                           <h5 class="font-size-14 mb-4">Status</h5>
                                           <div class="form-check mb-3">
                                               <input class="form-check-input" type="radio" name="status" id="inactive"  value="In Active" v-model="form.status">
                                               <label class="form-check-label" for="inactive">
                                                   In Active
                                               </label>
                                           </div>
                                           <div class="form-check">
                                               <input class="form-check-input" type="radio" name="status" id="active" value="Active" v-model="form.status">
                                               <label class="form-check-label" for="active">
                                                   Active
                                               </label>
                                           </div>
                                       </div>
                                       <span  v-if="form.errors.status" class="text-danger">{{form.errors.status}}</span>
                                   </div>
                               </div>
                                 <div class="col-md-6 d-none">
                                     <div class="row">
                                         <div class="justify-content-between">
                                             <h5>Add Category Params :   <button  @click="addFind()" type="button" class="btn btn-succe btn-sm bg-success text-white waves-effect ">  <i class="mdi mdi-account-plus-outline  "></i> Add  Field </button> </h5>
                                         </div>
                                         <div class="small text-danger">{{error_massage}}</div>
                                     </div>
                                      <div class="table-responsive">
                                          <table class="table  table-bordered">
                                              <tbody>
                                                  <tr v-for="(cat_val, index) in form.cat_values">
                                                      <td>
                                                          <div class="mb-3">
                                                              <input type="text" class="form-control"  v-model="cat_val.val" >
                                                              <input type="text" class="form-control"  v-model="cat_val.code"   >
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <div class="mb-3">
                                                              <button type="button" @click="remove_cat_val(index)" class="btn py-auto    btn-info bg-info waves-effect  ">
                                                                  <i class="mdi mdi-account-minus-outline  "></i>
                                                              </button>
                                                          </div>
                                                      </td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </div>

                                 </div>
                                 <div class="col-md-6">
                                     <div class="mb-3">
                                         <label for="desc" class="form-label">Description</label>
                                         <textarea type="text" class="form-control" rows="4" id="desc" name="desc" v-model="form.desc"></textarea>
                                         <span  v-if="form.errors.desc" class="text-danger">{{form.errors.desc}}</span>
                                     </div>
                                     <div class="md-3">
                                         <div class="mt-4">
                                             <h5 class="font-size-14 mb-4">Availability</h5>
                                             <div class="form-check mb-3">
                                                 <input class="form-check-input" type="radio" name="availability" id="availability"  value="available" v-model="form.availability">
                                                 <label class="form-check-label" for="availability">
                                                     Available
                                                 </label>
                                             </div>
                                             <div class="form-check">
                                                 <input class="form-check-input" type="radio" name="availability" id="not_available" value="not_available" v-model="form.availability">
                                                 <label class="form-check-label" for="not_available">
                                                     Not available
                                                 </label>
                                             </div>
                                         </div>
                                         <span  v-if="form.errors.status" class="text-danger">{{form.errors.availability}}</span>
                                     </div>
                                     <div class="mb-3">
                                         <label for="price" class="form-label">Price</label>
                                         <input type="number" class="form-control" rows="4" id="price" name="desc" v-model="form.price">
                                         <span  v-if="form.errors.price" class="text-danger">{{form.errors.price}}</span>
                                     </div>
                                 </div>
                             </div>
                              <div class="row  mt-2">
                                  <div class="col-md-4 mx-auto">
                                      <div class="mb-3 ">
                                          <button class="btn btn-primary px-5 waves-effect"  :disabled="form.processing" > Update {{pageName}}

                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>


      </app-layout>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/BackendLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Button from "../../../Jetstream/Button";
import Mixin from "../../../mixin";
import Input from "../../../Jetstream/Input";
export default {
    name: "Index",
    props: {
        pageName:String,
        urlName:String,
        status: String,
        item:Object,

    },
    data(){
        return{
            form: this.$inertia.form({
                cat_values: [
                    {
                        'code':'',
                        "val":'',
                    }
                ],

                availability:this.item.availability,
                id:this.item.id,
                price:this.item.price,
                code:this.item.code,
                discount_price:100,
                name:this.item.name ,
                image:'',
                desc:this.item.desc,
                status:this.item.status,
            }),
            error_massage:'',
        }
    },
    components: {
        Input,
        Button,
        AppLayout,
        Welcome,
        Head,
        Link
    },
    mixins:[Mixin],
    methods:{
        thumnailReturn(url){
          return 'http://127.0.0.1:8000/'+url;
        },
        remove_cat_val(index){
            if(this.form.cat_values.length<=1){
                this.error_massage = 'At least one field is require.';
            }else{
                this.error_massage='';
                this.form.cat_values.splice(index, 1);
            }
            this.codeInputer();

        },
        addFind: function () {
            this.error_massage='';
            this.form.cat_values.push({ code:'', val: '' });
            this.codeInputer();
        },
        submit() {
            this.form.put(this.route('resorts.update',this.form.id));

        },
        codeInputer(){
             var catValues =  this.form.cat_values;
             var _this =  this;
             catValues.forEach(function (rootValue,index) {
                  var inertialNumber = index+(+1);
                 rootValue.code = _this.form.code+inertialNumber;

             });
        }
    },
    mounted() {

    }


}
</script>

<style scoped>
 .preview_image{
     height: 120px;
     position: relative;
 }
 .preview_image:before {
     content: '';
     height:100%;
     width: 100%;
     position: absolute;
     top: 0;
     left: 0;
     background-color: black;
     color: mediumvioletred;
 }
 .preview_image_box{
     position: relative;
 }
 .preview_image_box span{
     font-size: 25px;
     position: absolute;
     z-index: 999;
     top:0;
     cursor: pointer;
     justify-content: center;
     padding: 3px 5px;
     background-color: #951d1d21;
     border-radius: 50px;
 }
</style>
