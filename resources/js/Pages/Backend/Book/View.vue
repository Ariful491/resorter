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
                          <div class="row mb-2">
                              <div class="col-md-10 mx-auto">
                                  <table class="table table-hover table-bordered ">
                                      <tr style="height: 20px">
                                          <th style="width: 40%">Name</th><td style="width: 20%">:</td><td width="40%">{{item.name}}</td>
                                      </tr>
                                      <tr style="height: 20px">
                                          <th style="width: 40%">Email</th><td style="width: 20%">:</td><td width="40%">{{item.email}}</td>
                                      </tr>
                                      <tr style="height: 20px">
                                          <th style="width: 40%">Address</th><td style="width: 20%">:</td><td width="40%">{{item.address}}</td>
                                      </tr>
                                      <tr style="height: 20px">
                                          <th style="width: 40%">From</th><td style="width: 20%">:</td><td width="40%">{{item.from_date}}</td>
                                      </tr>
                                      <tr style="height: 20px">
                                          <th style="width: 40%">To</th><td style="width: 20%">:</td><td width="40%">{{item.to_date}}</td>
                                      </tr>
                                      <tr style="height: 20px">
                                          <th style="width: 40%">Resort Details </th><td style="width: 20%">:</td><td style="width:40%; text-align: left!important" >
                                          <table class="table table-bordered">
                                              <tr style="height: 20px">
                                                  <th style="width: 40%">Resort Name</th><td style="width: 20%">:</td><td width="40%">{{item.resort.name}}</td>
                                              </tr>
                                              <tr style="height: 20px">
                                                  <th style="width: 40%">Image</th><td style="width: 20%">:</td><td width="40%"><img :src="thumbnail(item.resort.image)" class="img-fluid"></td>
                                              </tr>
                                          </table>
                                      </td>
                                      </tr>
                                      <tr style="height: 20px">
                                          <th style="width: 40%">Status</th><td style="width: 20%">:</td><td width="40%">{{item.status}}</td>
                                      </tr>

                                  </table>
                              </div>
                          </div>


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

    },


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
