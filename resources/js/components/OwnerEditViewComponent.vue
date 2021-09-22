<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ isEdit ? 'Edit' : 'View' }} Owner
                        <router-link class="float-right" to="/owners">
                            Owners
                        </router-link>
                    </div>

                    <div class="card-body">
                        <form class="form" @submit.prevent="saveOwner">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="first_name" v-model="owner.first_name" :disabled="!isEdit" />
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" v-model="owner.last_name" :disabled="!isEdit" />
                            </div>

                            <button type="submit" class="btn btn-primary" v-if="isEdit">Submit</button>
                        </form>

                        <div class="associated-entities" v-if="!isEdit">
                            <hr />
                            <div class="section">
                                <h5>Addresses</h5>
                                <div class="form-group" v-for="address in owner.addresses" :key="address.id">
                                    {{ address.address }}<br>
                                    {{ address.city }}<br>
                                    {{ address.country }}<br>
                                    {{ address.postal_code }}
                                </div>
                            </div>
                            <div class="section">
                                <h5>Cars</h5>
                                <div class="form-group" v-for="car in owner.cars" :key="car.id">
                                    {{ car.make }} {{ car.model }} {{ car.year }}
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
            owner: {},
            addresses: [],
            cars: [],
            action: '',
        }
    },
    created: function() {
        this.getOwner();
        this.action = this.$route.params.action;
    },
    computed: {
        isEdit: function () {
            return this.action === 'edit';
        }
    },
    methods: {
        getOwner: function() {
            axios.get(`/owner/${this.$route.params.id}`).then(function(res) {
                this.owner = res.data.owner;
                this.addresses = res.data.addresses;
                this.cars = res.data.cars;
            }.bind(this));
        },
        saveOwner: function() {
            axios.put(`/owner/${this.owner.id}`, {first_name: this.owner.first_name, last_name: this.owner.last_name})
                .then(function(res) {
                    this.$router.push('/owners');
                }.bind(this));
        }
    }
}
</script>
