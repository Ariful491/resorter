<template>
    <div class="row">
        <div class="col-md-4">
            <small>total {{shows}} of {{rows}}</small>
        </div>
        <div class="col-md-10">
            <div v-if="links.length >3">
                <div class="pagination pagination-rounded justify-content-end">
                    <template v-for="(link, key) in links">
                        <div v-if="link.url === null" :key="key" class="page-item disabled  " v-html="link.label" />
                        <Link v-else :key="`link-${key}`" class="page-link" :class="{ 'bg-primary text-white': link.active }" :href="link.url" v-html="link.label" />
                    </template>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
    name: "Pagination",
    components: {
        Link,
    },
    props: {
        links: Array,
         shows:Number,
         rows:Number
    },
    mounted(){

    }
}
</script>

<style scoped>
.pagination-rounded .page-link {
    border-radius: 5px!important;
    margin: 0 3px!important;
    border: none;
    width: 66px;
    height: 32px;
    padding: 0;
    text-align: center;
    line-height: 32px;
}
</style>
