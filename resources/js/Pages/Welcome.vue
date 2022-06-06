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
                <div v-if="$page.props.flash.success"  class="alert alert-primary" role="alert">
                    {{ $page.props.flash.success }}
                </div>

                <div class="col-md-4 " v-for="resort in resorts" :key="resort.id">
                    <div class="card mb-3" >
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img :src="resort.image" class="img-fluid rounded-start" :alt="resort.name">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{resort.name}}</h5>
                                    <p class="card-text">{{resort.desc}}</p>
                                    <p class="card-text">
                                        <Link class="btn btn-primary" :href="route('booking',resort.id)" >Book Now</Link>
                                    </p>
                                </div>
                            </div>
                        </div>
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

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            resorts:Object,
        }
    })
</script>
