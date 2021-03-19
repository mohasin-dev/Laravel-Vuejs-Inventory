<template>
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Supplier list <router-link class="btn btn-info text-right" to="/supplier/create">Add Supplier</router-link></h3>
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
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr v-for="supplier in searchsupplier" :key="supplier.id">
                                <td>{{ supplier.name }}</td>
                                <td>{{ supplier.email }}</td>
                                <td>{{ supplier.address }}</td>
                                <td>{{ supplier.phone }}</td>
                                <td><img width="50" :src="`assets/img/supplier/${supplier.photo}`"></td>
                                <td>
                                    <router-link :to="{name: 'editSupplier', params: {id: supplier.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                    <button @click="deletesupplier(supplier.id)" class="btn btn-sm btn-danger">Delete</button>
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
            suppliers: {},
            serachBy: ''
        }
    },

    created()
    {
        if (! Helper.loggedIn()) {
            this.$router.push({name: '/'});
        }

        this.getsupplier();
    },

    computed: {
        searchsupplier() {
            return Object.values(this.suppliers).filter(supplier => supplier.phone.match(this.serachBy))
            //return this.suppliers.filter(supplier => supplier.phone.match(this.serachBy))
            // return this.suppliers.filter(supplier => {
            //     return supplier.phone.match(this.serachBy);
            // });
        }
    },

    methods: {
        getsupplier() {
            axios.get(`/api/suppliers`)
            .then(response => {
                this.suppliers = response.data;
            })
            .catch(error => {
                if (error.response.status === 401) {
                    Notification.notify('Ops! something went wrong', 'error');
                }              
            });
        },
        deletesupplier(id) {  
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
                    axios.delete(`/api/suppliers/${id}`)
                    .then(response => {
                        Swal.fire (
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        //this.getsupplier();
                        this.suppliers = this.suppliers.filter(supplier => {
                            return supplier.id != id
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