<template>
    <Head title="Welcome" />
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Resort</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <Link class="nav-link active" aria-current="page"  :href="route('/')">Home</Link>
                    </li>
                </ul>
                <div class="d-flex">

                        <div v-if="canLogin" class="">
                            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-white">
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link :href="route('login')" class="text-white">
                                    Log in
                                </Link>

                                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                                    Register
                                </Link>
                            </template>
                        </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-white-50 mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card mb-3" >
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img :src="thumbnail(resort.image)" class="img-fluid rounded-start" :alt="resort.name">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{resort.name}}</h5>
                                    <p class="card-text">{{resort.desc}}</p>
                                    <p class="card-text">{{resort.price}}</p>
                                </div>
                            </div>
                        </div>
                  <form enctype="multipart/form-data"  @submit.prevent="submit"  action="">
                        <div class="row mx-5 my-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" v-model="form.name">
                                    <span  v-if="form.errors.name" class="text-danger">{{form.errors.name}}</span>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" v-model="form.email">
                                    <span  v-if="form.errors.email" class="text-danger">{{form.errors.email}}</span>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea   class="form-control" id="address" name="address" v-model="form.address"></textarea>
                                    <span  v-if="form.errors.address" class="text-danger">{{form.errors.address}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="from_date" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" v-model="form.from_date">
                                    <span  v-if="form.errors.from_date" class="text-danger">{{form.errors.from_date}}</span>
                                </div>
                                <div class="mb-3">
                                    <label for="to_date" class="form-label">To Date</label>
                                    <input type="date"  class="form-control" id="to_date" name="to_date" v-model="form.to_date">
                                    <span  v-if="form.errors.to_date" class="text-danger">{{form.errors.to_date}}</span>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary px-5 py-2">Booking Confirm</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Button from "../Jetstream/Button";

    export default defineComponent({
        components: {
            Button,
            Head,
            Link,
        },
       data(){
            return{
                form: this.$inertia.form({
                    name:'',
                    email:'',
                    address:'',
                    from_date:'',
                    to_date:'',
                    id:this.id,

                }),
            }
       },


        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            id:Number,
            resort:Object,
        },
        methods:{
            thumbnail(url){
                   return 'http://127.0.0.1:8000/'+url;
             },
            submit() {
                this.form.post(this.route('book.store'));
            },

        }
    })
</script>
