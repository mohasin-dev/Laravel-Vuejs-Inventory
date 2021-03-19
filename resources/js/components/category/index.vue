<template>
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">category list <router-link class="btn btn-info text-right" to="/category/create">Add category</router-link></h3>
            </div>
            <div class="card-body">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group" style="margin-bottom: 10px;">
                        <input type="text" v-model="serachBy" class="form-control bg-light border-0 small" placeholder="Search by phone" aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Parent category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Category Name</th>
                                <th>Parent category</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr v-for="category in searchCategory" :key="category.id">
                                <td>{{ category.name }}</td>
                                <td v-if="category.parent">
                                    {{ category.parent.name }} 
                                </td>
                                <td v-else>
                                    No parent category found
                                </td>
                                <td>
                                    <router-link :to="{name: 'editCategory', params: {id: category.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                    <button @click="deletecategory(category.id)" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: {},
            serachBy: ''
        }
    },

    created()
    {
        if (! Helper.loggedIn()) {
            this.$router.push({name: '/'});
        }

        this.getCategory();
    },

    computed: {
        searchCategory() {
            return Object.values(this.categories).filter(category => category.name.match(this.serachBy))
            //return this.categories.filter(category => category.phone.match(this.serachBy))
            // return this.categories.filter(category => {
            //     return category.phone.match(this.serachBy);
            // });
        }
    },

    methods: {
        getCategory() {
            axios.get(`/api/categories`)
            .then(response => {
                this.categories = response.data;
                console.log(response.data);
            })
            .catch(error => {
                if (error.response.status === 401) {
                    Notification.notify('Ops! something went wrong', 'error');
                }              
            });
        },
        deletecategory(id) {  
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/categories/${id}`)
                    .then(response => {
                        Swal.fire (
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        //this.getcategory();
                        this.categories = this.categories.filter(category => {
                            return category.id != id
                        })
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            Notification.notify('Ops! something went wrong', 'error');
                        }              
                    });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>