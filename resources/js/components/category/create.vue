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
                                <h1 class="h4 text-gray-900 mb-4">Add new category <router-link to="/category" class="btn btn-info">All category</router-link></h1>
                            </div>
                            <form @submit.prevent="addCategory" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Category name</label>
                                        <input type="text" v-model="form.name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Name">
                                        <small class="text-danger"
                                                v-if="errors.name">{{ errors.name[0] }}</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Parent Category name (Optional)</label>
                                        <v-select :options="categories"
                                        :reduce="category => category.id"
                                         label="name"
                                         v-model="form.parent_category_id">
                                        </v-select>
                                        <!-- <input type="email" v-model="form.email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address"> -->
                                        <small class="text-danger"
                                                v-if="errors.parent_category_id">{{ errors.parent_category_id[0] }}</small>
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
            categories: [],
            form: {
                name: '',
                parent_category_id: '',
            },
            errors: {}
        }
    },

    created()
    {
        if (! Helper.loggedIn()) {
            this.$router.push({name: '/'});
        }
        this.getCategory();
    },

    methods: {
        getCategory() {
            axios.get('/api/categories')
            .then(response => {
                this.categories = response.data;
                console.log(response.data);
            })
            .catch(error => {
                Notification.notify('Ops! Something wnt wrong', 'error');       
            });
        },
        addCategory() {
            axios.post('/api/categories', this.form)
            .then(response => {
                Notification.notify('Category successfully added!', 'success');
                this.$router.push({name: 'category'});
            })
            .catch(error => {
                if (error.response.status === 401) {
                    Notification.notify('Ops! Something wnt wrong', 'error');
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