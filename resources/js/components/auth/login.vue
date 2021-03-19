<template>
    <div>
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form @submit.prevent="login" class="user">
                                        <div class="form-group">
                                            <input type="email" 
                                            v-model="form.email"
                                            class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                            <small class="text-danger"
                                                    v-if="errors.email">{{ errors.email[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" 
                                            v-model="form.password"
                                            class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                            <small class="text-danger"
                                                    v-if="errors.password">{{ errors.password[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <!-- <a href="index.html" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a> -->
                                        <!-- <router-link to="/" class="btn btn-primary btn-user btn-block">Login</router-link> -->
                                        <button class="btn btn-primary btn-user btn-block"> Login </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <!-- <a class="small" href="#">Forgot Password?</a> -->
                                        <router-link to="/forget" class="small">Forgot Password?</router-link>
                                    </div>
                                    <div class="text-center">
                                        <router-link to="/register" class="small">Create an Account!</router-link>
                                    </div>
                                </div>
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
                email: '',
                password: '',
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
        login() {
            axios.post('/api/auth/login', this.form)
            .then(response =>  {
                Helper.responseAfterLogin(response);
                Toast.fire({
                    icon: 'success',
                    title: 'Welcome back! You are logged in'
                });
                this.$router.push({name: 'home'});
            })
            .catch(error => {
                if (error.response.status === 401) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invaild email or password!'
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