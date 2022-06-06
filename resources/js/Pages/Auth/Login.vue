<template>
    <Head title="Log in" />
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 mx-auto my-auto">
                <jet-authentication-card class="card px-3 py-5  mx-auto ">
                     <template #logo class="text-center" >
                                <jet-authentication-card-logo  class="logoImage"  />
                       </template>
                    <jet-validation-errors class="mb-4" />
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <form @submit.prevent="submit" class="mx-4 my-4">
                        <div >
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class=" form-control mt-1 block w-full" v-model="form.email" required autofocus />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password" value="Password" />
                            <jet-input id="password" type="password" class="form-control mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label class="flex items-center">
                                <jet-checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 text-sm text-gray-600 form-check">Remember me</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                Forgot your password?
                            </Link>

                            <jet-button class="ml-4 btn btn-primary waves-effect" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Log in
                            </jet-button>
                        </div>
                    </form>
                </jet-authentication-card>
            </div>
        </div>
    </div>

</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,

            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
<style   >

svg.w-16.h-16 {
    height: 52px;
    text-align: center;
}
</style>
