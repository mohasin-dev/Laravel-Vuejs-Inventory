<template>
    <div>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form @submit.prevent="register" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="form.name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Name">
                                        <small class="text-danger"
                                                v-if="errors.name">{{ errors.name[0] }}</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" v-model="form.email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                        <small class="text-danger"
                                                v-if="errors.email">{{ errors.email[0] }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" v-model="form.password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                            <small class="text-danger"
                                                v-if="errors.password">{{ errors.password[0] }}</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" v-model="form.password_confirmation" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 offset-sm-3 mb-3 mb-sm-0">
                                        <input type="password" v-model="form.phone" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Phone Number">
                                            <small class="text-danger"
                                                v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block"> Register Account </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <router-link to="/forget" class="small">Forgot Password?</router-link>
                            </div>
                            <div class="text-center">
                                <!-- <a class="small" href="login.html">Already have an account? Login!</a> -->
                                <router-link to="/" class="small">Already have an account? Login!</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
            },
            errors: {}
        }
    },

    created()
    {
        if (Helper.loggedIn()) {
            this.$router.push({name: 'home'});
        }
    },

    methods: {
        register() {
            axios.post('/api/auth/register', this.form)
            .then(response =>  {
                Helper.responseAfterLogin(response);
                Toast.fire({
                    icon: 'success',
                    title: 'Registration successfull!'
                });
                this.$router.push({name: 'home'});
            })
            .catch(error => {
                if (error.response.status === 401) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Ops! something went wrong'
                    });
                } else {
                    this.errors = error.response.data.errors
                }                
            });
        }   
    }
}
</script>

<style scoped>

</style>