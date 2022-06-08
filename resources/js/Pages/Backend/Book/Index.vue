<template>
  <div>
      <app-layout title="Booking List">

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

                              <div class="col-sm-2">
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

                              <div class="col-sm-3">
                                  <div class="search-box me-2 mb-2 d-inline-block">
                                      <div class="position-relative">
                                          <input type="text" class="form-control" @keyup="filterer()" v-model="this.searchValue" placeholder="Search...">
                                          <i class="bx bx-search-alt search-icon"></i>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-5">
                                  <form action="" @submit.prevent="filterer()">
                                      <div class="input-daterange input-group"     >
                                          <input type="date" class="form-control" v-model="from_date" name="from_date" placeholder="Start Date">
                                          <input type="date" class="form-control" v-model="to_date" name="end" placeholder="End Date">
                                          <button class="btn btn-sm btn-info"   type="submit">submit</button>
                                      </div>
                                  </form>
                              </div>
<!--                              <div class="col-sm-3">-->
<!--                                  <div class="text-sm-end">-->
<!--                                      <Link  :href="route(urlName+'.create')" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New-->
<!--                                          {{ pageName }}</Link>-->
<!--                                  </div>-->
<!--                              </div>&lt;!&ndash; end col&ndash;&gt;-->
                          </div>

                          <div class="table-responsive mt-3">
                              <table class="table align-middle table-nowrap table-check">
                                  <thead class="table-light">
                                  <tr>
<!--                                      <th style="width: 20px;" class="align-middle">-->
<!--                                          <div class="form-check font-size-16">-->
<!--                                              <input class="form-check-input" type="checkbox" id="checkAll">-->
<!--                                              <label class="form-check-label" for="checkAll"></label>-->
<!--                                          </div>-->
<!--                                      </th>-->

                                      <th class="align-middle sort-css" @click="sorter('code')"># <i class="bx bx-bx bx-up-arrow-alt"></i> </th>
                                      <th class="align-middle sort-css" @click="sorter('name')">  Name  <i class="bx bx-bx bx-up-arrow-alt"></i> </th>
                                      <th class="align-middle sort-css" @click="sorter('email')">  Email  <i class="bx bx-bx bx-up-arrow-alt"></i> </th>

                                      <th class="align-middle sort-css" @click="sorter('address')">Address  <i class="bx bx-bx bx-up-arrow-alt"></i></th>
                                      <th class="align-middle sort-css" @click="sorter('price')">From Date<i class="bx bx-bx bx-up-arrow-alt"></i></th>
                                      <th class="align-middle sort-css" @click="sorter('price')">To Date<i class="bx bx-bx bx-up-arrow-alt"></i></th>
                                      <th class="align-middle sort-css" @click="sorter('status')">Status  <i class="bx bx-bx bx-up-arrow-alt"></i> </th>

                                      <th class="align-middle sort-css">Action </th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr v-if="countTotal<1">
                                      <td colspan="8"   class="alert text-center alert-info" role="alert">there is no data</td>
                                  </tr>
                                    <tr v-else v-for="item in data.data">
                                      <td><a href="javascript: void(0);" class="text-body fw-bold">#SK{{item.id}}</a> </td>
                                      <td>{{item.name}}</td>
                                      <td>
                                          {{item.email}}
                                      </td>
                                      <td>
                                          {{item.address}}
                                      </td>
                                      <td>
                                          <span class="badge badge-pill badge-soft-success font-size-12">{{item.from_date}}</span>
                                      </td>
                                      <td>
                                          <span class="badge badge-pill badge-soft-success font-size-12">{{item.to_date}}</span>
                                      </td>
                                      <td>
                                          <div class="dropdown">
                                               <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">{{item.status}} <i class="bx bx-bx bx-down-arrow"></i></button>
                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                  <li><a @click="status(item.id,'cancel')" class="dropdown-item" href="#">Cancel</a></li>
                                                  <li><a @click="status(item.id,'confirm')" class="dropdown-item" href="#">Confirm</a></li>
                                              </ul>
                                          </div>
                                      </td>
                                      <td>
                                          <div class="d-flex gap-3">
                                              <Link :href="route('books.show',item.id)" class="text-success">View</Link>
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
            from_date:'',
            to_date:'',
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
            this.$inertia.visit('books',
                {
                    method: 'get',
                    data: {
                        paginatItem:this.paginatItem,
                        searchValue:this.searchValue,
                        from_date:this.from_date,
                        to_date:this.to_date,

                    },
                });
            // this.props.update();
            // this.form.get(this.route('categories.index',this.paginatItem));
        },
        destroy(id) {
            this.$inertia.delete(route("books.destroy", id));
        },
        sorter(name){
                    if (this.sorting===''){
                        this.sorting='asc'
                    }else {
                        this.sorting='desc'
                    }

                this.ordering_item =  name;

           if (this.ordering_item != null){
               this.$inertia.visit('books',
                   {
                       method: 'get',
                       data: {
                           sort:this.sorting,
                           column:this.ordering_item,

                       },
                   });
           }


        },
        status(id,status){
            this.$inertia.post(route("books.status", {
                'id':id,
                'status':status,

            }))
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
