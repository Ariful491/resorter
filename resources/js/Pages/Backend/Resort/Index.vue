<template>
  <div>
      <app-layout title="Resorts">

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
                  <div v-if="$page.props.flash.success"  class="alert alert-primary" role="alert">
                      {{ $page.props.flash.success }}
                  </div>

              <div class="card">
                      <div class="card-body">
                          <div class="row mb-2">

                              <div class="col-sm-4">
                                  <div class="search-box me-2 mb-2 d-inline-block">
                                          <select  @change="filterer()" v-model="paginatItem" class="form-select"  >
                                              <option value="10">10</option>
                                              <option value="20">20</option>
                                              <option value="50">50</option>
                                              <option value="100">100</option>
                                              <option value="500">500</option>
                                              <option value="999999">All</option>
                                          </select>
                                  </div>
                              </div>
                              <div class="col-sm-4">
                                  <div class="search-box me-2 mb-2 d-inline-block">
                                      <div class="position-relative">
                                          <input type="text" class="form-control" @keyup="filterer()" v-model="this.searchValue" placeholder="Search...">
                                          <i class="bx bx-search-alt search-icon"></i>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-4">
                                  <div class="text-sm-end">
                                      <Link  :href="route(urlName+'.create')" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New
                                          {{ pageName }}</Link>
                                  </div>
                              </div><!-- end col-->
                          </div>

                          <div class="table-responsive">
                              <table class="table align-middle table-nowrap table-check">
                                  <thead class="table-light">
                                  <tr>
<!--                                      <th style="width: 20px;" class="align-middle">-->
<!--                                          <div class="form-check font-size-16">-->
<!--                                              <input class="form-check-input" type="checkbox" id="checkAll">-->
<!--                                              <label class="form-check-label" for="checkAll"></label>-->
<!--                                          </div>-->
<!--                                      </th>-->

                                      <th class="align-middle sort-css" @click="sorter('code')">Resort Code  <i class="bx bx-bx bx-up-arrow-alt"></i> </th>
                                      <th class="align-middle sort-css" @click="sorter('name')"> Resort Name  <i class="bx bx-bx bx-up-arrow-alt"></i> </th>
                                      <th class="align-middle"> Image  </th>
                                      <th class="align-middle sort-css" @click="sorter('price')">Price  <i class="bx bx-bx bx-up-arrow-alt"></i></th>
                                      <th class="align-middle sort-css" @click="sorter('availability')">Availability Status  <i class="bx bx-bx bx-up-arrow-alt"></i></th>
                                      <th class="align-middle sort-css" @click="sorter('status')">Status  <i class="bx bx-bx bx-up-arrow-alt"></i> </th>

                                      <th class="align-middle sort-css">Action </th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr v-if="countTotal<1">
                                      <td colspan="7"   class="alert text-center alert-info" role="alert">there is no data</td>
                                  </tr>
                                    <tr v-else v-for="item in data.data">
<!--                                      <td>-->
<!--                                          <div class="form-check font-size-16">-->
<!--                                              <input class="form-check-input" type="checkbox" id="orderidcheck01">-->
<!--                                              <label class="form-check-label" for="orderidcheck01"></label>-->
<!--                                          </div>-->
<!--                                      </td>-->
                                      <td><a href="javascript: void(0);" class="text-body fw-bold">#SK{{item.code}}</a> </td>
                                      <td>{{item.name}}</td>
                                      <td>
                                          <img :src="item.image" class="img-fluid resize rounded" >
                                      </td>
                                      <td>
                                          {{item.price}}
                                      </td>
                                      <td>
                                          <span class="badge badge-pill badge-soft-success font-size-12">{{item.availability}}</span>
                                      </td>
                                      <td>
                                          <i class="fab fa-cc-mastercard me-1"></i> {{item.status}}
                                      </td>
                                      <td>
                                          <div class="d-flex gap-3">
                                              <Link :href="route('resorts.edit',item.id)" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></Link>
                                              <a href="javascript:void(0);" @click="destroy(item.id)"  class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                          </div>
                                      </td>
                                  </tr>
                                  </tbody>
                              </table>
                          </div>

                          <pagination :links="data.links" :rows="rows" :shows="countTotal" />
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
import Pagination from "../../../Components/Pagination";

export default {
    name: "Index",
    components: {
        Pagination,
        AppLayout,
        Welcome,
        Head,
        Link
    },
    data(){
        return{
            paginatItem:10,
            searchValue:"",
            ordering_item:'',
            sorting:'',
        }
    },
    props: {
        pageName:String,
        urlName:String,
        data: Object,
        rows:Number,
        paginate:Number,
        countTotal:Number,


    },
    methods:{
        filterer:function () {
            this.$inertia.visit('resorts',
                {
                    method: 'get',
                    data: {
                        paginatItem:this.paginatItem,
                        searchValue:this.searchValue,

                    },
                });
            // this.props.update();
            // this.form.get(this.route('categories.index',this.paginatItem));
        },
        destroy(id) {
            this.$inertia.delete(route("resorts.destroy", id));
        },
        sorter(name){
                    if (this.sorting===''){
                        this.sorting='asc'
                    }else {
                        this.sorting='desc'
                    }

                this.ordering_item =  name;

           if (this.ordering_item != null){
               this.$inertia.visit('resorts',
                   {
                       method: 'get',
                       data: {
                           sort:this.sorting,
                           column:this.ordering_item,

                       },
                   });
           }


        }
    },
    mounted(){

    }
}
</script>

<style scoped>
.resize{
    height: 180px;
}
.sort-css{
    cursor: pointer;
}
</style>
