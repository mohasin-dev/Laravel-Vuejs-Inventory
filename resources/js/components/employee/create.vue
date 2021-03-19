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
                                <h1 class="h4 text-gray-900 mb-4">Add new Employee <router-link to="/employee" class="btn btn-info">All Employee</router-link></h1>
                            </div>
                            <form @submit.prevent="addEmployee" class="user">
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
                                <div class="form-group">
                                        <textarea type="text" v-model="form.address" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Address"></textarea>
                                        <small class="text-danger"
                                                v-if="errors.address">{{ errors.address[0] }}</small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="form.phone" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Phone Number">
                                        <small class="text-danger"
                                                v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" v-model="form.salary" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Salary">
                                        <small class="text-danger"
                                                v-if="errors.salary">{{ errors.salary[0] }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Date of joining</label>
                                        <input type="date" v-model="form.date_of_joining" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Date of joining">
                                        <small class="text-danger"
                                                v-if="errors.date_of_joining">{{ errors.date_of_joining[0] }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Photo</label><br>
                                        <input type="file" @change="onFileSelected">
                                        <small class="text-danger"
                                                v-if="errors.photo">{{ errors.photo[0] }}</small>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                        <img :src="form.photo" alt="Photo" width="100" height="50px">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block"> Save </button>
                            </form>
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
                address: '',
                salary: '',
                date_of_joining: '',
                phone: '',
                photo: '',
            },
            errors: {}
        }
    },

    created()
    {
        if (! Helper.loggedIn()) {
            this.$router.push({name: '/'});
        }
    },

    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1000000) {
                Notification.notify('Image must be less than 1 mb', 'warning');
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result
                }
                reader.readAsDataURL(file);
            }
        },

        addEmployee() {
            axios.post('/api/employees', this.form)
            .then(response =>  {
                Notification.notify('Employee successfully added!', 'success');
                this.$router.push({name: 'employee'});
            })
            .catch(error => {
                if (error.response.status === 401) {
                    Notification.notify('Ops! something wnt wrong', 'error');
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